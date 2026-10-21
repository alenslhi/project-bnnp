<?php

namespace App\Http\Controllers;

use App\Models\GameMitosFakta;
use App\Models\GameWordle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Bank soal Mitos/Fakta dan Kata Target Wordle harian.
     * Terdapat 7 tema berbeda yang berotasi otomatis setiap hari.
     */
    private array $rotationalPuzzles = [
        [
            'theme' => 'Ketergantungan Zat & Pemulihan',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'CANDU',
                    'length' => 5,
                    'hint' => 'Kondisi keterikatan fisik dan psikologis kuat pada zat adiktif yang dijelaskan di Mitos/Fakta.',
                    'definition' => 'CANDU: Ketergantungan atau adiksi yang terjadi saat zat narkotika membajak sistem dopamin otak sehingga pengguna merasa tak berdaya tanpanya.'
                ],
                [
                    'index' => 2,
                    'word' => 'REHAB',
                    'length' => 5,
                    'hint' => 'Layanan medis dan sosial resmi BNN tanpa ancaman pidana bagi penyalahguna yang ingin pulih.',
                    'definition' => 'REHAB: Singkatan dari Rehabilitasi, proses perawatan medis dan psikososial terpadu agar pecandu dapat pulih seutuhnya dan kembali produktif.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Mencoba narkoba jenis sabu atau narkotika sintetis hanya satu kali tidak akan bikin kecanduan.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Adiksi & Otak',
                    'explanation' => 'Zat narkotika modern bekerja membanjiri dopamin otak hingga 10x lipat alami. Efek ini memicu sifat keterikatan akut atau rasa CANDU sejak pemakaian pertama.',
                    'clue' => 'Perhatikan istilah kondisi keterikatan akut zat adiktif: CANDU.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Pecandu narkoba yang melapor sukarela ke BNN untuk rehabilitasi tidak akan dipenjara atau dipidana.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Hukum & Regulasi',
                    'explanation' => 'Berdasarkan UU No. 35 Tahun 2009 Pasal 54 & 55, korban penyalahgunaan yang melapor sukarela ke BNN atau IPWL berhak menjalani REHAB (rehabilitasi) gratis tanpa proses hukum pidana.',
                    'clue' => 'Perhatikan program pemulihan resmi tanpa pidana bagi pecandu: REHAB.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Narkoba stimulan dapat meningkatkan stamina belajar dan konsentrasi bekerja secara aman.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Efek Farmakologi',
                    'explanation' => 'Stimulan hanya memberikan energi palsu dengan memeras cadangan tubuh secara paksa. Efek akhirnya adalah kerusakan sel saraf, depresi berat, paranoia, dan halusinasi.',
                    'clue' => 'Energi buatan narkoba hanyalah tipuan yang memicu siklus adiksi dan candu berkepanjangan.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Keluarga memiliki kewajiban hukum untuk melaporkan anggota keluarga yang belum cukup umur jika kecanduan narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Peran Keluarga',
                    'explanation' => 'Sesuai UU Narkotika Pasal 55, orang tua atau wali dari pecandu yang belum cukup umur wajib melaporkannya ke institusi resmi agar segera mendapatkan layanan rehabilitasi medis.',
                    'clue' => 'Langkah terbaik menyelamatkan masa depan keluarga adalah segera membawanya ke pusat rehab.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Kecanduan narkoba semata-mata adalah kegagalan moral, bukan penyakit medis.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Kesehatan Mental',
                    'explanation' => 'Organisasi Kesehatan Dunia (WHO) dan BNN menetapkan adiksi sebagai penyakit otak kronis kambuhan (Chronic Relapsing Brain Disease) yang memerlukan terapi medis dan psikososial profesional.',
                    'clue' => 'Sebagai penyakit kronis, pemulihan adiksi membutuhkan proses intervensi medis di tempat rehab.'
                ]
            ]
        ],
        [
            'theme' => 'Zat Berbahaya & Pola Hidup Sehat',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'RACUN',
                    'length' => 5,
                    'hint' => 'Zat toksik berbahaya dalam narkotika yang merusak organ vital tubuh.',
                    'definition' => 'RACUN: Zat kimia destruktif di dalam narkotika yang mengendap dan merusak hati, ginjal, jantung, dan jutaan sel otak.'
                ],
                [
                    'index' => 2,
                    'word' => 'SEHAT',
                    'length' => 5,
                    'hint' => 'Kondisi fisik dan mental prima yang terbebas dari jeratan zat berbahaya.',
                    'definition' => 'SEHAT: Keadaan bugar seimbang secara fisik, psikologis, dan sosial yang dipertahankan melalui pola hidup positif tanpa narkoba.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Narkoba hanya berdampak pada pikiran penggunanya, sedangkan organ dalam tubuh tetap aman.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Kerusakan Fisik',
                    'explanation' => 'Semua jenis narkoba mengandung senyawa kimia berbahaya yang bertindak sebagai RACUN bagi tubuh, menyebabkan gagal ginjal, sirosis hati, dan gagal jantung.',
                    'clue' => 'Kata kunci pertama: senyawa toksik perusak organ tubuh adalah RACUN.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Olahraga teratur dan hobi positif mampu memicu hormon bahagia alami yang jauh lebih sehat daripada zat terlarang.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Gaya Hidup',
                    'explanation' => 'Aktivitas fisik memicu produksi endorfin dan serotonin alami yang membuat pikiran tenang, tubuh segar, dan jiwa tetap SEHAT tanpa ketergantungan bahan kimia.',
                    'clue' => 'Kata kunci kedua: gaya hidup bugar tanpa narkoba adalah SEHAT.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Minum air kelapa hijau atau susu murni sesaat setelah memakai narkoba bisa membersihkan racun seketika.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Mitos Populer',
                    'explanation' => 'Zat narkotika larut dalam lemak dan peredaran darah hingga berpekan-pekan. Susu atau air kelapa tidak bisa menetralkan endapan racun dalam pemeriksaan laboratorium forensik.',
                    'clue' => 'Zat racun narkotika tidak dapat hilang hanya dengan minuman biasa.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Generasi muda yang memiliki ketahanan diri (resilience) memiliki risiko terjerumus narkoba yang jauh lebih rendah.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Pencegahan Remaja',
                    'explanation' => 'BNN membangun program Remaja Teman Sebaya untuk melatih ketahanan diri agar anak muda memiliki pergaulan yang sehat dan berani menolak bujukan negatif.',
                    'clue' => 'Keluarga dan pergaulan yang sehat menjadi perisai paling kokoh dari bahaya narkotika.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Berhenti memakai narkoba secara mendadak sendirian di kamar (cold turkey) tanpa dokter selalu aman.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Penanganan Sakaw',
                    'explanation' => 'Gejala sakaw berat dapat memicu kejang, serangan jantung, halusinasi akut, hingga kematian karena tubuh syok melawan pelepasan racun zat secara drastis tanpa obat pendamping.',
                    'clue' => 'Detoksifikasi dari racun narkoba harus diawasi ketat oleh dokter spesialis.'
                ]
            ]
        ],
        [
            'theme' => 'Regulasi Narkotika & Asa Pemulihan',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'GANJA',
                    'length' => 5,
                    'hint' => 'Tanaman narkotika Golongan I yang dilarang keras beredar di Indonesia.',
                    'definition' => 'GANJA: Tanaman Cannabis sativa yang mengandung THC psikoaktif terlarang berdasarkan UU No. 35 Tahun 2009 tentang Narkotika.'
                ],
                [
                    'index' => 2,
                    'word' => 'PULIH',
                    'length' => 5,
                    'hint' => 'Kondisi bangkit dan terbebas dari belenggu adiksi narkotika.',
                    'definition' => 'PULIH: Keadaan ketika seseorang yang pernah kecanduan berhasil sembuh, stabil emosionalnya, dan kembali berkarya di tengah masyarakat.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Di wilayah hukum Indonesia, ganja diperbolehkan untuk dikonsumsi bebas dalam jumlah kecil untuk santai.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Aspek Hukum',
                    'explanation' => 'Hukum Indonesia secara tegas menggolongkan GANJA ke dalam Narkotika Golongan I. Memiliki, menyimpan, atau mengonsumsinya merupakan tindak pidana serius.',
                    'clue' => 'Kata kunci pertama: tanaman narkotika Golongan I terlarang di Indonesia adalah GANJA.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Mantan pengguna narkoba yang tekun mengikuti program rehabilitasi memiliki peluang besar untuk sembuh.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Pemulihan',
                    'explanation' => 'Dengan terapi perilaku dan pendampingan pascarehabilitasi BNN, ratusan mantan pecandu terbukti berhasil PULIH, mandiri, dan memiliki masa depan cerah.',
                    'clue' => 'Kata kunci kedua: kondisi bebas dan sembuh dari ketergantungan adalah PULIH.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Ganja adalah tanaman alami sehingga tidak memiliki efek samping dan tidak menyebabkan kecanduan.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Efek Medis',
                    'explanation' => 'Senyawa Tetrahidrokanabinol (THC) dalam ganja merusak daya ingat jangka pendek, menurunkan motivasi belajar, dan memicu ketergantungan psikologis kronis.',
                    'clue' => 'Meskipun alami, tanaman ganja tetap memiliki efek psikoaktif yang berbahaya bagi otak.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Penerimaan keluarga tanpa diskriminasi mempercepat pemulihan mantan pengguna narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Dukungan Sosial',
                    'explanation' => 'Stigma sosial memperbesar peluang kekambuhan (relapse). Dukungan keluarga yang hangat dan suportif adalah kunci utama agar mantan penyalahguna pulih seutuhnya.',
                    'clue' => 'Dukungan moril keluarga mengantarkan korban narkoba pulih dan produktif kembali.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Asap ganja lebih aman bagi paru-paru dibandingkan asap tembakau biasa.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Bahaya Pernapasan',
                    'explanation' => 'Hasil riset medis membuktikan asap pembakaran ganja mengandung senyawa tar karsinogenik yang lebih pekat dan mempercepat kerusakan alveolus paru-paru.',
                    'clue' => 'Asap pembakaran tanaman ganja merusak saluran napas secara signifikan.'
                ]
            ]
        ],
        [
            'theme' => 'Alat Penularan Penyakit & Akal Sehat',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'JARUM',
                    'length' => 5,
                    'hint' => 'Alat suntik yang sering disalahgunakan dan memicu penularan virus mematikan.',
                    'definition' => 'JARUM: Alat injeksi suntik yang jika digunakan bergantian oleh pecandu menjadi media penularan paling berbahaya untuk virus HIV dan Hepatitis C.'
                ],
                [
                    'index' => 2,
                    'word' => 'WARAS',
                    'length' => 5,
                    'hint' => 'Kondisi akal sehat dan kejernihan pikiran yang terjaga tanpa gangguan zat adiktif.',
                    'definition' => 'WARAS: Keadaan pikiran yang sadar penuh, rasional, dan sehat mental, terbebas dari delusi atau psikosis akibat narkotika.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Menggunakan alat suntik narkoba bergantian dengan teman dekat tidak berisiko tertular penyakit darah.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Penyakit Menular',
                    'explanation' => 'Berbagi JARUM suntik bekas adalah penyebab utama ledakan penularan virus HIV/AIDS dan Hepatitis C yang merusak kekebalan tubuh hingga berujung kematian.',
                    'clue' => 'Kata kunci pertama: alat suntik medis yang disalahgunakan adalah JARUM.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Zat narkotika jenis stimulan dan halusinogen dapat memicu gangguan jiwa berat (psikosis).',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Kesehatan Jiwa',
                    'explanation' => 'Narkotika merusak sel otak secara permanen, menimbulkan delusi kejar, paranoid, dan halusinasi yang merampas kondisi pikiran yang WARAS dari penggunanya.',
                    'clue' => 'Kata kunci kedua: pikiran sehat dan berakal budi adalah WARAS.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Membilas jarum suntik bekas pakai dengan air panas keran sudah cukup membunuh virus HIV.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Mitos Medis',
                    'explanation' => 'Virus di dalam lumen jarum sangat terlindung oleh sisa sel darah beku dan tidak bisa steril hanya dengan bilasan air panas sederhana tanpa autoklaf bertekanan.',
                    'clue' => 'Sisa darah di dalam jarum suntik tetap menyimpan potensi penularan virus mematikan.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Konseling psikologis dan psikiatri adalah cara tepat mengatasi trauma mental tanpa pelarian ke narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Solusi Mental',
                    'explanation' => 'Mencari bantuan profesional menjaga stabilitas mental dan mengembalikan pikiran yang waras tanpa terjebak ketergantungan obat terlarang.',
                    'clue' => 'Bimbingan psikologis yang tepat menjaga pikiran tetap waras menghadapi ujian hidup.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Pecandu narkoba suntik hanya berasal dari kalangan jalanan, bukan kalangan berpendidikan.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Fakta Sosial',
                    'explanation' => 'Data BNN menunjukkan penyalahgunaan narkoba tidak memandang status sosial, ekonomi, maupun tingkat pendidikan, sehingga semua kalangan wajib waspada.',
                    'clue' => 'Bahaya penyalahgunaan jarum suntik mengintai siapa saja tanpa membedakan latar belakang.'
                ]
            ]
        ],
        [
            'theme' => 'Modus Kamuflase & Hidup Bebas Narkoba',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'VAPOR',
                    'length' => 5,
                    'hint' => 'Asap atau uap rokok elektrik yang kini rawan disusupi liquid narkotika sintetis.',
                    'definition' => 'VAPOR: Uap dari perangkat rokok elektrik/vape yang marak disalahgunakan sindikat narkoba untuk mencampur cairan ganja sintetis (sinte).'
                ],
                [
                    'index' => 2,
                    'word' => 'BEBAS',
                    'length' => 5,
                    'hint' => 'Kondisi merdeka tanpa belenggu zat narkotika yang merusak masa depan.',
                    'definition' => 'BEBAS: Keadaan merdeka sejati bagi generasi muda untuk berkarya dan meraih cita-cita tanpa jeratan adiksi dan hukum.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Cairan (liquid) rokok elektrik atau vape dijamin 100% aman dan tidak pernah dicampur zat narkotika.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Modus Baru (NPS)',
                    'explanation' => 'BNN berulang kali membongkar peredaran cairan narkotika sintetis (tembakau gorila cair) yang dikemas dalam liquid perangkat VAPOR.',
                    'clue' => 'Kata kunci pertama: istilah terkait uap rokok elektrik yang rawan disusupi narkoba adalah VAPOR.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Masa depan gemilang dan prestasi tinggi hanya bisa diraih dengan tekad hidup bersih tanpa narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Cita-cita Generasi',
                    'explanation' => 'Generasi yang BEBAS dari jeratan zat adiktif memiliki fokus mental yang prima, fisik yang bugar, dan peluang karir tanpa catatan kriminal.',
                    'clue' => 'Kata kunci kedua: kondisi merdeka dari belenggu narkoba adalah BEBAS.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Narkoba berbentuk permen atau kue kering aman karena dijual di warung bebas.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Waspada Modus',
                    'explanation' => 'Sindikat sengaja membuat kamuflase narkotika dalam bentuk makanan ringan manis untuk menjebak remaja pemula agar tidak dicurigai orang tua dan guru.',
                    'clue' => 'Waspadai berbagai kamuflase zat adiktif yang merampas kebebasan masa depan generasi muda.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Masyarakat dapat melaporkan kecurigaan peredaran narkoba ke Call Center BNN secara aman dan rahasia.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Peran Serta Warga',
                    'explanation' => 'Kerahasiaan identitas pelapor dilindungi undang-undang demi menciptakan lingkungan pemukiman yang bebas dari sarang pengedar.',
                    'clue' => 'Laporan aktif dari warga mewujudkan pemukiman yang bebas narkotika.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Narkotika jenis sintetis efeknya lebih ringan daripada narkotika alami.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Bahaya Kimia Sintetis',
                    'explanation' => 'Narkotika sintetis (seperti sabu dan sinte) memiliki daya rusak terhadap sel otak hingga ratusan kali lebih berbahaya dan memicu gagal jantung mendadak.',
                    'clue' => 'Zat sintetis dalam campuran liquid vape atau serbuk merenggut kendali bebas pikiran.'
                ]
            ]
        ],
        [
            'theme' => 'Manajemen Stres & Ketegasan Menolak',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'STRES',
                    'length' => 5,
                    'hint' => 'Beban pikiran atau tekanan mental yang sering disalahgunakan sebagai alasan memakai narkoba.',
                    'definition' => 'STRES: Tekanan mental atau emosional yang semestinya dikelola melalui cara positif, bukan dengan pelarian semu ke zat terlarang.'
                ],
                [
                    'index' => 2,
                    'word' => 'TEGAS',
                    'length' => 5,
                    'hint' => 'Sikap berani dan lugas dalam menolak tawaran narkoba tanpa ragu-ragu.',
                    'definition' => 'TEGAS: Sikap asertif dan berkepribadian kuat untuk mengatakan TIDAK pada narkoba demi masa depan diri sendiri.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Mengonsumsi pil penenang tanpa resep dokter adalah solusi tercepat dan efektif mengatasi beban stres.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Kesehatan Emosi',
                    'explanation' => 'Menyalahgunakan obat penenang untuk lari dari STRES justru menciptakan toleransi obat, ketergantungan kronis, dan memperburuk depresi saat efek obat habis.',
                    'clue' => 'Kata kunci pertama: tekanan mental yang salah kaprah diobati dengan narkoba adalah STRES.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Menolak ajakan teman untuk mencicipi narkoba dengan lugas adalah tanda kepribadian yang berkarakter kuat.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Karakter Tangguh',
                    'explanation' => 'Sikap TEGAS menolak bujukan kawan sebaya (peer pressure) adalah bentuk keberanian sejati untuk melindungi masa depan dan kehormatan keluarga.',
                    'clue' => 'Kata kunci kedua: sikap lugas menolak narkoba adalah TEGAS.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Narkoba bisa menyelesaikan masalah hidup dan mendatangkan ide-ide kreatif permanen.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Ilusi Narkoba',
                    'explanation' => 'Narkoba tidak menyelesaikan masalah apapun. Narkoba justru menambah masalah baru berupa sanksi hukum pidana, hancurnya karir, dan keretakan keluarga.',
                    'clue' => 'Tekanan masalah tidak boleh dilampiaskan pada penyalahgunaan zat berbahaya.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Keterampilan komunikasi asertif sangat penting diajarkan pada siswa sekolah.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Edukasi Sekolah',
                    'explanation' => 'Sikap asertif membekali generasi muda agar berani bersikap tegas tanpa rasa canggung atau takut kehilangan teman yang berniat buruk.',
                    'clue' => 'Melatih keberanian bersikap tegas adalah modal dasar perlindungan diri dari narkotika.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Mencoba narkoba jenis apa pun adalah keputusan pribadi yang tidak merugikan orang lain.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Dampak Sosial',
                    'explanation' => 'Penyalahgunaan narkoba berdampak langsung pada hancurnya masa depan keluarga, tingginya angka kriminalitas jalanan, dan kerugian ekonomi bangsa.',
                    'clue' => 'Keluarga yang mengalami tekanan mental akibat korban narkoba membutuhkan ketegasan sikap hukum.'
                ]
            ]
        ],
        [
            'theme' => 'Zat Kimia Beracun & Kesadaran Diri',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'KIMIA',
                    'length' => 5,
                    'hint' => 'Zat atau senyawa sintetis buatan pabrik gelap yang mematikan sel tubuh.',
                    'definition' => 'KIMIA: Senyawa sintetis beracun yang diracik tanpa standar farmasi di laboratorium gelap peredaran narkotika.'
                ],
                [
                    'index' => 2,
                    'word' => 'SADAR',
                    'length' => 5,
                    'hint' => 'Kondisi eling, waspada, dan memiliki pemahaman mendalam tentang bahaya narkoba.',
                    'definition' => 'SADAR: Kesadaran moral, hukum, dan kesehatan untuk senantiasa waspada terhadap ancaman peredaran gelap narkoba di sekitar kita.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Narkoba sintetis yang dibuat di laboratorium rumahan terjamin steril dan higienis.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Pabrik Gelap',
                    'explanation' => 'Sindikat ilegal mencampur bahan KIMIA berbahaya seperti aseton, pembersih lantai, dan pupuk untuk menghasilkan sabu atau ekstasi murah yang mematikan.',
                    'clue' => 'Kata kunci pertama: senyawa sintetik berbahaya dalam narkoba adalah KIMIA.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Masyarakat yang memiliki kesadaran tinggi merupakan pilar utama program Desa Bersinar (Bersih Narkoba).',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Desa Bersinar',
                    'explanation' => 'Warga yang SADAR akan bahaya laten narkoba akan proaktif mengawasi lingkungan tempat tinggalnya dan membimbing anak-anak agar tidak terjerumus.',
                    'clue' => 'Kata kunci kedua: sikap tanggap dan waspada terhadap narkoba adalah SADAR.'
                ],
                [
                    'id' => 3,
                    'statement' => 'Minum obat batuk cair dalam jumlah puluhan saset sekaligus aman karena obat warung.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Penyalahgunaan Obat',
                    'explanation' => 'Overdosis dekstrometorfan menyebabkan intoksikasi senyawa kimia berat yang merusak fungsi hati dan memicu halusinasi berbahaya.',
                    'clue' => 'Penyalahgunaan bahan kimia obat bebas membawa efek fatal bagi kesehatan sistem saraf.'
                ],
                [
                    'id' => 4,
                    'statement' => 'Komunikasi hangat dan terbuka antara orang tua dan anak adalah benteng pertama pencegahan narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Ketahanan Keluarga',
                    'explanation' => 'Keluarga yang saling peduli menciptakan anak yang sadar diri, memiliki rasa percaya diri tinggi, dan tidak mudah terbujuk pergaulan menyimpang.',
                    'clue' => 'Kasih sayang orang tua menumbuhkan kepribadian anak yang sadar dan berani menolak zat terlarang.'
                ],
                [
                    'id' => 5,
                    'statement' => 'Narkotika hanya berbahaya bila digunakan dalam bentuk serbuk atau pil telan saja.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Bentuk Narkoba',
                    'explanation' => 'Narkoba diproduksi dalam beragam wujud: kertas perangko hisap (LSD), cairan hirup, kristal, hingga lem bakar. Semuanya mengandung bahan kimia adiktif perusak sel otak.',
                    'clue' => 'Semua wujud olahan kimia narkotika memiliki dampak destruktif yang sama bagi tubuh.'
                ]
            ]
        ]
    ];

    /**
     * Tampilkan halaman utama Game Edukasi SKENA.
     */
    public function index(Request $request): View
    {
        $today = Carbon::today()->toDateString();
        $offset = (int) $request->cookie('skena_set_offset', 0);

        if ($request->has('reset')) {
            // Setiap kali di-reset, berganti ke set soal baru berikutnya!
            $offset = $offset + 1;
            cookie()->queue('skena_set_offset', (string) $offset, 60 * 24 * 30);
            cookie()->queue(cookie()->forget('skena_game_done_' . $today));
        }

        if ($request->has('set')) {
            $offset = max(0, (int) $request->input('set') - 1);
            cookie()->queue('skena_set_offset', (string) $offset, 60 * 24 * 30);
            cookie()->queue(cookie()->forget('skena_game_done_' . $today));
        }

        $puzzleData = $this->getDailyPuzzle($today, $offset);

        return view('publik.game', [
            'todayDate' => $today,
            'todayFormatted' => Carbon::today()->locale('id')->isoFormat('D MMMM Y'),
            'puzzle' => $puzzleData,
        ]);
    }

    /**
     * Endpoint API publik untuk mengambil data tantangan hari ini.
     */
    public function dailyData(Request $request): JsonResponse
    {
        $today = Carbon::today()->toDateString();
        $offset = (int) $request->cookie('skena_set_offset', 0);
        if ($request->has('set')) {
            $offset = max(0, (int) $request->input('set') - 1);
        }
        $puzzleData = $this->getDailyPuzzle($today, $offset);

        return response()->json([
            'date' => $today,
            'date_formatted' => Carbon::today()->locale('id')->isoFormat('D MMMM Y'),
            'puzzle' => $puzzleData,
        ]);
    }

    /**
     * Mendapatkan set tantangan harian berdasarkan tanggal.
     * Mengambil secara dinamis dari database 100 soal Mitos/Fakta & 100 Kata Wordle.
     */
    private function getDailyPuzzle(string $dateString, int $customOffset = 0): array
    {
        $date = Carbon::parse($dateString);
        $dayOfYear = $date->dayOfYear;

        try {
            $totalQuestions = GameMitosFakta::where('is_active', true)->count();
            $totalWords = GameWordle::where('is_active', true)->count();

            if ($totalQuestions >= 5 && $totalWords >= 2) {
                // 100 soal dibagi 5 per hari = 20 set unik sebelum rotasi
                $setCount = max(1, intdiv($totalQuestions, 5));
                $setIndex = (($dayOfYear - 1) + $customOffset) % $setCount;
                if ($setIndex < 0) $setIndex += $setCount;
                $qOffset = $setIndex * 5;

                $questions = GameMitosFakta::where('is_active', true)
                    ->orderBy('id', 'asc')
                    ->skip($qOffset)
                    ->take(5)
                    ->get();

                // 100 kata dibagi 2 per hari = 50 pasang kata unik sebelum rotasi
                $wordPairCount = max(1, intdiv($totalWords, 2));
                $wordPairIndex = (($dayOfYear - 1) + $customOffset) % $wordPairCount;
                if ($wordPairIndex < 0) $wordPairIndex += $wordPairCount;
                $wOffset = $wordPairIndex * 2;

                $words = GameWordle::where('is_active', true)
                    ->orderBy('id', 'asc')
                    ->skip($wOffset)
                    ->take(2)
                    ->get();

                $theme = $questions->first()->badge ?? 'Edukasi Narkotika P4GN';

                return [
                    'set_number' => $setIndex + 1,
                    'theme' => $theme,
                    'words' => $words->values()->map(function ($w, $idx) {
                        return [
                            'index' => $idx + 1,
                            'word' => strtoupper($w->word),
                            'length' => (int) ($w->length ?: strlen($w->word)),
                            'hint' => $w->hint,
                            'definition' => $w->definition,
                        ];
                    })->toArray(),
                    'questions' => $questions->values()->map(function ($q, $idx) {
                        return [
                            'id' => $idx + 1,
                            'statement' => $q->statement,
                            'is_fakta' => (bool) $q->is_fakta,
                            'badge' => $q->badge,
                            'explanation' => $q->explanation,
                            'clue' => $q->clue,
                        ];
                    })->toArray(),
                ];
            }
        } catch (\Throwable $e) {
            // Fallback ke array statis jika koneksi atau tabel bermasalah
        }

        // Fallback statis bawaan
        $totalSets = count($this->rotationalPuzzles);
        $setIndex = $dayOfYear % $totalSets;
        $selectedSet = $this->rotationalPuzzles[$setIndex];

        return [
            'set_number' => $setIndex + 1,
            'theme' => $selectedSet['theme'],
            'words' => $selectedSet['words'],
            'questions' => $selectedSet['questions'],
        ];
    }

    /**
     * Endpoint API untuk Mode Latihan / Uji Coba Bebas (Testing tanpa batas).
     * Mengambil 5 soal acak dan 2 kata acak dari 150 database setiap kali dipanggil.
     */
    public function randomData(Request $request): JsonResponse
    {
        try {
            $questions = GameMitosFakta::where('is_active', true)
                ->inRandomOrder()
                ->take(5)
                ->get();

            $words = GameWordle::where('is_active', true)
                ->inRandomOrder()
                ->take(2)
                ->get();

            if ($questions->count() >= 5 && $words->count() >= 2) {
                $theme = 'Mode Latihan: ' . ($questions->first()->badge ?? 'Edukasi Narkotika');

                $puzzle = [
                    'set_number' => rand(1, 999),
                    'theme' => $theme,
                    'words' => $words->values()->map(function ($w, $idx) {
                        return [
                            'index' => $idx + 1,
                            'word' => strtoupper($w->word),
                            'length' => (int) ($w->length ?: strlen($w->word)),
                            'hint' => $w->hint,
                            'definition' => $w->definition,
                        ];
                    })->toArray(),
                    'questions' => $questions->values()->map(function ($q, $idx) {
                        return [
                            'id' => $idx + 1,
                            'statement' => $q->statement,
                            'is_fakta' => (bool) $q->is_fakta,
                            'badge' => $q->badge,
                            'explanation' => $q->explanation,
                            'clue' => $q->clue,
                        ];
                    })->toArray(),
                ];

                return response()->json([
                    'success' => true,
                    'mode' => 'random_practice',
                    'puzzle' => $puzzle,
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Fallback jika database belum tersedia
        $today = Carbon::today()->toDateString();
        return response()->json([
            'success' => true,
            'mode' => 'fallback',
            'puzzle' => $this->getDailyPuzzle($today),
        ]);
    }

    /**
     * Endpoint Reset Status Hari Ini (Khusus Testing / Developer Mode).
     * Menghapus cookie pembatas harian sehingga bisa langsung diuji coba ulang.
     */
    public function resetToday(Request $request): JsonResponse
    {
        $today = Carbon::today()->toDateString();
        cookie()->queue(cookie()->forget('skena_game_done_' . $today));

        return response()->json([
            'success' => true,
            'message' => 'Status tantangan hari ini berhasil di-reset untuk pengujian.',
            'date' => $today
        ]);
    }

    /**
     * Endpoint untuk mencatat upaya pemain (opsional, untuk sinkronisasi cookie / session).
     */
    public function recordAttempt(Request $request): JsonResponse
    {
        $today = Carbon::today()->toDateString();
        $status = $request->input('status', 'played'); // won, lost, played

        // Pasang cookie bahwa hari ini sudah memainkan game
        $minutesUntilMidnight = max(1, Carbon::now()->diffInMinutes(Carbon::tomorrow()));
        cookie()->queue('skena_game_done_' . $today, $status, $minutesUntilMidnight);

        return response()->json([
            'success' => true,
            'message' => 'Upaya tantangan harian berhasil dicatat.',
            'date' => $today,
            'status' => $status
        ]);
    }
}
