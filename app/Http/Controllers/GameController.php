<?php

namespace App\Http\Controllers;

use App\Models\GameLeaderboard;
use App\Models\GameMitosFakta;
use App\Models\GameWordle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Bank soal Mitos/Fakta dan Kata Target Wordle harian.
     * Terdapat 7 tema berbeda yang berotasi otomatis setiap hari.
     */
    private array $rotationalPuzzles = [
        [
            'theme' => 'Bahaya Zat Adiktif & Pemulihan',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'CANDU',
                    'length' => 5,
                    'hint' => 'Rasa ketagihan yang bikin pengen pakai narkoba terus-menerus (5 huruf).',
                    'definition' => 'CANDU: Ketergantungan atau adiksi yang terjadi saat zat narkotika membajak sistem dopamin otak sehingga pengguna merasa tak berdaya tanpanya.'
                ],
                [
                    'index' => 2,
                    'word' => 'REHAB',
                    'length' => 5,
                    'hint' => 'Tempat perawatan dan pemulihan bagi orang yang kecanduan narkoba (5 huruf).',
                    'definition' => 'REHAB: Singkatan dari Rehabilitasi, proses perawatan medis dan psikososial terpadu agar pecandu dapat pulih seutuhnya dan kembali produktif.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Mencoba narkoba jenis sabu atau narkotika sintetis hanya satu kali tidak akan bikin kecanduan.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Adiksi & Otak',
                    'explanation' => 'Zat narkotika modern bekerja membanjiri dopamin otak hingga 10x lipat alami. Efek ini memicu sifat keterikatan akut atau rasa candu sejak pemakaian pertama.',
                    'clue' => 'Kondisi keterikatan fisik dan psikologis yang kuat pada zat adiktif.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Pecandu narkoba yang melapor sukarela ke BNN untuk rehabilitasi tidak akan dipenjara atau dipidana.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Hukum & Regulasi',
                    'explanation' => 'Berdasarkan UU No. 35 Tahun 2009 Pasal 54 & 55, korban penyalahgunaan yang melapor sukarela ke BNN atau IPWL berhak menjalani rehabilitasi (rehab) gratis tanpa proses hukum pidana.',
                    'clue' => 'Layanan perawatan medis dan sosial resmi bagi pemulihan ketergantungan.'
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
                    'hint' => 'Zat berbahaya dalam narkoba yang mematikan dan merusak organ tubuh (5 huruf).',
                    'definition' => 'RACUN: Zat kimia destruktif di dalam narkotika yang mengendap dan merusak hati, ginjal, jantung, dan jutaan sel otak.'
                ],
                [
                    'index' => 2,
                    'word' => 'SEHAT',
                    'length' => 5,
                    'hint' => 'Kondisi tubuh bugar dan tidak sakit, lawan kata dari sakit (5 huruf).',
                    'definition' => 'SEHAT: Keadaan bugar seimbang secara fisik, psikologis, dan sosial yang dipertahankan melalui pola hidup positif tanpa narkoba.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Narkoba hanya berdampak pada pikiran penggunanya, sedangkan organ dalam tubuh tetap aman.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Kerusakan Fisik',
                    'explanation' => 'Semua jenis narkoba mengandung senyawa kimia berbahaya yang bertindak sebagai racun bagi tubuh, menyebabkan gagal ginjal, sirosis hati, dan gagal jantung.',
                    'clue' => 'Senyawa berbahaya perusak organ vital tubuh.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Olahraga teratur dan hobi positif mampu memicu hormon bahagia alami yang jauh lebih sehat daripada zat terlarang.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Gaya Hidup',
                    'explanation' => 'Aktivitas fisik memicu produksi endorfin dan serotonin alami yang membuat pikiran tenang, tubuh segar, dan jiwa tetap sehat tanpa ketergantungan bahan kimia.',
                    'clue' => 'Kondisi fisik dan mental prima yang terbebas dari zat berbahaya.'
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
                    'hint' => 'Tanaman terlarang dengan daun hijau menjari yang sering dilinting (5 huruf).',
                    'definition' => 'GANJA: Tanaman Cannabis sativa yang mengandung THC psikoaktif terlarang berdasarkan UU No. 35 Tahun 2009 tentang Narkotika.'
                ],
                [
                    'index' => 2,
                    'word' => 'PULIH',
                    'length' => 5,
                    'hint' => 'Keadaan sembuh kembali seperti semula setelah diobati (5 huruf).',
                    'definition' => 'PULIH: Keadaan ketika seseorang yang pernah kecanduan berhasil sembuh, stabil emosionalnya, dan kembali berkarya di tengah masyarakat.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Di wilayah hukum Indonesia, ganja diperbolehkan untuk dikonsumsi bebas dalam jumlah kecil untuk santai.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Aspek Hukum',
                    'explanation' => 'Hukum Indonesia secara tegas menggolongkan tanaman ganja ke dalam Narkotika Golongan I. Memiliki, menyimpan, atau mengonsumsinya merupakan tindak pidana serius.',
                    'clue' => 'Tanaman terlarang pembawa kandungan senyawa psikoaktif.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Mantan pengguna narkoba yang tekun mengikuti program rehabilitasi memiliki peluang besar untuk sembuh.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Pemulihan',
                    'explanation' => 'Dengan terapi perilaku dan pendampingan pascarehabilitasi BNN, ratusan mantan pecandu terbukti berhasil pulih, mandiri, dan memiliki masa depan cerah.',
                    'clue' => 'Kondisi kesembuhan dan terbebas dari ketergantungan zat.'
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
                    'hint' => 'Benda tajam runcing pada alat suntik narkoba yang rawan tular virus (5 huruf).',
                    'definition' => 'JARUM: Alat injeksi suntik yang jika digunakan bergantian oleh pecandu menjadi media penularan paling berbahaya untuk virus HIV dan Hepatitis C.'
                ],
                [
                    'index' => 2,
                    'word' => 'WARAS',
                    'length' => 5,
                    'hint' => 'Pikiran sehat dan berakal budi, lawan kata dari gila atau hilang akal (5 huruf).',
                    'definition' => 'WARAS: Keadaan pikiran yang sadar penuh, rasional, dan sehat mental, terbebas dari delusi atau psikosis akibat narkotika.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Menggunakan alat suntik narkoba bergantian dengan teman dekat tidak berisiko tertular penyakit darah.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Penyakit Menular',
                    'explanation' => 'Berbagi jarum suntik bekas adalah penyebab utama ledakan penularan virus HIV/AIDS dan Hepatitis C yang merusak kekebalan tubuh hingga berujung kematian.',
                    'clue' => 'Alat medis yang berbahaya bila disalahgunakan secara bergantian.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Zat narkotika jenis stimulan dan halusinogen dapat memicu gangguan jiwa berat (psikosis).',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Kesehatan Jiwa',
                    'explanation' => 'Narkotika merusak sel otak secara permanen, menimbulkan delusi kejar, paranoid, dan halusinasi yang merampas kondisi pikiran yang waras dari penggunanya.',
                    'clue' => 'Kondisi pikiran yang sehat dan berakal budi jernih.'
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
            'theme' => 'Narkotika Kristal & Hidup Bebas Narkoba',
            'words' => [
                [
                    'index' => 1,
                    'word' => 'SABU',
                    'length' => 4,
                    'hint' => 'Narkotika jenis kristal putih yang sering diisap dengan alat bong (4 huruf).',
                    'definition' => 'SABU: Metamfetamin kristal yang merusak sistem saraf otak dan memicu paranoia akut.'
                ],
                [
                    'index' => 2,
                    'word' => 'BEBAS',
                    'length' => 5,
                    'hint' => 'Kondisi merdeka dan terlepas dari jeratan narkoba (5 huruf).',
                    'definition' => 'BEBAS: Keadaan merdeka sejati bagi generasi muda untuk berkarya dan meraih cita-cita tanpa jeratan adiksi dan hukum.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Narkoba jenis sabu kristal aman dikonsumsi asalkan dalam jumlah kecil untuk menambah stamina.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Bahaya Sabu',
                    'explanation' => 'Sabu adalah zat metamfetamin yang sangat adiktif dan langsung merusak sel otak sejak pemakaian pertama serta memicu stroke mendadak.',
                    'clue' => 'Narkotika kristal putih perusak sistem saraf otak.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Masa depan gemilang dan prestasi tinggi hanya bisa diraih dengan tekad hidup bersih tanpa narkoba.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Cita-cita Generasi',
                    'explanation' => 'Generasi yang bebas dari jeratan zat adiktif memiliki fokus mental yang prima, fisik yang bugar, dan peluang karir tanpa catatan kriminal.',
                    'clue' => 'Kondisi merdeka dari ketergantungan dan belenggu narkotika.'
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
                    'clue' => 'Zat sintetis kristal merenggut kendali bebas pikiran manusia.'
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
                    'hint' => 'Beban pikiran atau tekanan mental yang berat (5 huruf).',
                    'definition' => 'STRES: Tekanan mental atau emosional yang semestinya dikelola melalui cara positif, bukan dengan pelarian semu ke zat terlarang.'
                ],
                [
                    'index' => 2,
                    'word' => 'TEGAS',
                    'length' => 5,
                    'hint' => 'Sikap berani menolak ajakan memakai narkoba tanpa ragu-ragu (5 huruf).',
                    'definition' => 'TEGAS: Sikap asertif dan berkepribadian kuat untuk mengatakan TIDAK pada narkoba demi masa depan diri sendiri.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Mengonsumsi pil penenang tanpa resep dokter adalah solusi tercepat dan efektif mengatasi beban stres.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Kesehatan Emosi',
                    'explanation' => 'Menyalahgunakan obat penenang untuk lari dari stres justru menciptakan toleransi obat, ketergantungan kronis, dan memperburuk depresi saat efek obat habis.',
                    'clue' => 'Tekanan psikologis yang membutuhkan penanganan sehat.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Menolak ajakan teman untuk mencicipi narkoba dengan lugas adalah tanda kepribadian yang berkarakter kuat.',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Karakter Tangguh',
                    'explanation' => 'Sikap tegas menolak bujukan kawan sebaya (peer pressure) adalah bentuk keberanian sejati untuk melindungi masa depan dan kehormatan keluarga.',
                    'clue' => 'Sikap lugas dan teguh mempertahankan prinsip diri.'
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
                    'hint' => 'Bahan sintetis buatan pabrik yang dicampur dalam narkoba terlarang (5 huruf).',
                    'definition' => 'KIMIA: Senyawa sintetis beracun yang diracik tanpa standar farmasi di laboratorium gelap peredaran narkotika.'
                ],
                [
                    'index' => 2,
                    'word' => 'SADAR',
                    'length' => 5,
                    'hint' => 'Kondisi pikiran jernih, lawan kata dari pingsan atau teler (5 huruf).',
                    'definition' => 'SADAR: Kesadaran moral, hukum, dan kesehatan untuk senantiasa waspada terhadap ancaman peredaran gelap narkoba di sekitar kita.'
                ]
            ],
            'questions' => [
                [
                    'id' => 1,
                    'statement' => 'Narkoba sintetis yang dibuat di laboratorium rumahan terjamin steril dan higienis.',
                    'is_fakta' => false, // Mitos
                    'badge' => 'Pabrik Gelap',
                    'explanation' => 'Sindikat ilegal mencampur bahan kimia berbahaya seperti aseton, pembersih lantai, dan pupuk untuk menghasilkan sabu atau ekstasi murah yang mematikan.',
                    'clue' => 'Senyawa sintetis berbahaya yang merusak sistem saraf.'
                ],
                [
                    'id' => 2,
                    'statement' => 'Masyarakat yang memiliki kesadaran tinggi merupakan pilar utama program Desa Bersinar (Bersih Narkoba).',
                    'is_fakta' => true, // Fakta
                    'badge' => 'Desa Bersinar',
                    'explanation' => 'Warga yang sadar akan bahaya laten narkoba akan proaktif mengawasi lingkungan tempat tinggalnya dan membimbing anak-anak agar tidak terjerumus.',
                    'clue' => 'Kondisi akal yang jernih dan tanggap terhadap lingkungan sekitar.'
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
        $today = GameLeaderboard::getCurrentPeriodDate();
        $nextResetCarbon = GameLeaderboard::getNextResetCarbon();

        // Bersihkan session/cookie skena_set_offset lama jika pernah tersimpan dari masa pengujian
        if ($request->hasCookie('skena_set_offset') || $request->session()->has('skena_set_offset')) {
            $request->session()->forget('skena_set_offset');
            cookie()->queue(cookie()->forget('skena_set_offset'));
        }

        $offset = 0;
        if ($request->has('set')) {
            $offset = max(0, (int) $request->input('set') - 1);
        }

        $puzzleData = $this->getDailyPuzzle($today, $offset);

        return view('publik.game', [
            'todayDate' => $today,
            'todayFormatted' => Carbon::parse($today)->locale('id')->isoFormat('D MMMM Y'),
            'puzzle' => $puzzleData,
            'nextResetIso' => $nextResetCarbon->toIso8601String(),
            'nextResetFormatted' => $nextResetCarbon->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WITA',
        ]);
    }

    /**
     * Endpoint API publik untuk mengambil data tantangan hari ini.
     */
    public function dailyData(Request $request): JsonResponse
    {
        $today = GameLeaderboard::getCurrentPeriodDate();
        $nextResetCarbon = GameLeaderboard::getNextResetCarbon();
        $offset = 0;
        if ($request->has('set')) {
            $offset = max(0, (int) $request->input('set') - 1);
        }
        $puzzleData = $this->getDailyPuzzle($today, $offset);

        return response()->json([
            'date' => $today,
            'date_formatted' => Carbon::parse($today)->locale('id')->isoFormat('D MMMM Y'),
            'puzzle' => $puzzleData,
            'next_reset_iso' => $nextResetCarbon->toIso8601String(),
            'next_reset_formatted' => $nextResetCarbon->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WITA',
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

                // 2 kata Wordle per hari dikorelasikan langsung dengan 5 soal Mitos/Fakta hari tersebut
                // Setiap set soal (Set 1 s.d. 20) berpasangan langsung dengan kata Wordle (Kata 1 s.d. 40)
                $wOffset = ($setIndex * 2) % max(1, $totalWords - 1);

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
        $setIndex = (($dayOfYear - 1) + $customOffset) % $totalSets;
        if ($setIndex < 0) {
            $setIndex += $totalSets;
        }
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
        $today = GameLeaderboard::getCurrentPeriodDate();
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
        $today = GameLeaderboard::getCurrentPeriodDate();
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
        $today = GameLeaderboard::getCurrentPeriodDate();
        $nextReset = GameLeaderboard::getNextResetCarbon();
        $status = $request->input('status', 'played'); // won, lost, played

        // Pasang cookie hingga reset berikutnya pukul 07:00 WITA
        $minutesUntilReset = max(1, Carbon::now('Asia/Makassar')->diffInMinutes($nextReset));
        cookie()->queue('skena_game_done_' . $today, $status, $minutesUntilReset);

        return response()->json([
            'success' => true,
            'message' => 'Upaya permainan berhasil dicatat.',
            'date' => $today,
            'status' => $status,
            'reset_at' => $nextReset->toIso8601String()
        ]);
    }

    /**
     * Endpoint Mengambil Data Papan Peringkat (Leaderboard).
     * Direset setiap hari pukul 07:00 WITA.
     */
    public function leaderboardData(Request $request): JsonResponse
    {
        $currentPeriod = GameLeaderboard::getCurrentPeriodDate();
        $requestedPeriod = $request->query('period', $currentPeriod);

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $requestedPeriod)) {
            $requestedPeriod = $currentPeriod;
        }

        $nextResetCarbon = GameLeaderboard::getNextResetCarbon();
        $nowWita = Carbon::now('Asia/Makassar');
        $secondsUntilReset = max(0, $nowWita->diffInSeconds($nextResetCarbon, false));

        $query = GameLeaderboard::where('period_date', $requestedPeriod)
            ->orderBy('total_score', 'desc')
            ->orderBy('duration_seconds', 'asc')
            ->orderBy('created_at', 'asc');

        $totalParticipants = $query->count();
        $entries = $query->take(50)->get();

        $rankedList = $entries->values()->map(function ($item, $index) {
            $rank = $index + 1;
            return [
                'id' => $item->id,
                'rank' => $rank,
                'player_name' => $item->player_name,
                'player_organization' => $item->player_organization,
                'total_score' => (int) $item->total_score,
                'duration_seconds' => (int) $item->duration_seconds,
                'duration_formatted' => sprintf('%02d:%02d', intdiv($item->duration_seconds, 60), $item->duration_seconds % 60),
                'quiz_score' => (int) $item->quiz_score,
                'quiz_correct_count' => (int) $item->quiz_correct_count,
                'word1_score' => (int) $item->word1_score,
                'word1_attempts' => (int) $item->word1_attempts,
                'word2_score' => (int) $item->word2_score,
                'word2_attempts' => (int) $item->word2_attempts,
                'speed_bonus' => (int) $item->speed_bonus,
                'retry_penalty' => (int) $item->retry_penalty,
                'retry_count' => (int) $item->retry_count,
                'is_top_3' => $rank <= 3,
                'is_top_10' => $rank <= 10,
                'created_at' => $item->created_at->format('H:i'),
            ];
        });

        $top10 = $rankedList->slice(0, 10)->values();
        $others = $rankedList->slice(10)->values();

        $periodFormatted = Carbon::parse($requestedPeriod)->locale('id')->isoFormat('D MMMM Y');

        // Cari data posisi peringkat pemain aktif saat ini (Live Rank)
        $playerRankInfo = null;
        try {
            $fingerprint = $request->query('device_fingerprint');
            $playerName = $request->query('player_name');

            $myRecord = null;
            if (!empty($fingerprint)) {
                $myRecord = GameLeaderboard::where('period_date', $requestedPeriod)
                    ->where('device_fingerprint', $fingerprint)
                    ->first();
            }
            if (!$myRecord && !empty($playerName)) {
                $myRecord = GameLeaderboard::where('period_date', $requestedPeriod)
                    ->where('player_name', $playerName)
                    ->first();
            }

            if ($myRecord) {
                $myRank = GameLeaderboard::where('period_date', $requestedPeriod)
                    ->where(function ($q) use ($myRecord) {
                        $q->where('total_score', '>', $myRecord->total_score)
                          ->orWhere(function ($q2) use ($myRecord) {
                              $q2->where('total_score', '=', $myRecord->total_score)
                                 ->where('duration_seconds', '<', $myRecord->duration_seconds);
                          })
                          ->orWhere(function ($q3) use ($myRecord) {
                              $q3->where('total_score', '=', $myRecord->total_score)
                                 ->where('duration_seconds', '=', $myRecord->duration_seconds)
                                 ->where('created_at', '<', $myRecord->created_at);
                          });
                    })
                    ->count() + 1;

                $playerRankInfo = [
                    'found' => true,
                    'id' => $myRecord->id,
                    'rank' => $myRank,
                    'is_top_3' => ($myRank <= 3),
                    'is_top_10' => ($myRank <= 10),
                    'player_name' => $myRecord->player_name,
                    'total_score' => (int) $myRecord->total_score,
                    'duration_seconds' => (int) $myRecord->duration_seconds,
                ];
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return response()->json([
            'success' => true,
            'period_date' => $requestedPeriod,
            'period_formatted' => $periodFormatted,
            'is_current_period' => ($requestedPeriod === $currentPeriod),
            'next_reset_iso' => $nextResetCarbon->toIso8601String(),
            'next_reset_formatted' => $nextResetCarbon->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WITA',
            'seconds_until_reset' => $secondsUntilReset,
            'total_participants' => $totalParticipants,
            'top_10' => $top10,
            'others' => $others,
            'all' => $rankedList,
            'player_rank' => $playerRankInfo,
        ]);
    }

    /**
     * Endpoint Mengirim Skor Pemain ke Papan Peringkat (Leaderboard).
     */
    public function submitScore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'player_name' => 'required|string|min:2|max:50',
            'player_organization' => 'nullable|string|max:80',
            'quiz_correct_count' => 'required|integer|min:0|max:5',
            'word1_attempts' => 'required|integer|min:1|max:6',
            'word2_attempts' => 'required|integer|min:1|max:6',
            'word1_won' => 'required|boolean',
            'word2_won' => 'required|boolean',
            'duration_seconds' => 'required|integer|min:1|max:86400',
            'retry_count' => 'nullable|integer|min:0|max:100',
            'device_fingerprint' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $periodDate = GameLeaderboard::getCurrentPeriodDate();

        // Hitung skor komprehensif di sisi server
        $computed = GameLeaderboard::computeScore($validated);

        $playerName = trim(strip_tags($validated['player_name']));
        $playerOrg = isset($validated['player_organization']) ? trim(strip_tags($validated['player_organization'])) : null;
        $fingerprint = $validated['device_fingerprint'] ?? null;
        $ip = $request->ip();

        // Cek rekor pemain pada periode aktif hari ini
        // Utamakan pencarian berdasarkan device_fingerprint agar pemain/perangkat yang sama tidak menduplikasi diri atau menurunkan skor
        $existing = null;
        if (!empty($fingerprint)) {
            $existing = GameLeaderboard::where('period_date', $periodDate)
                ->where('device_fingerprint', $fingerprint)
                ->first();
        }
        if (!$existing) {
            $existing = GameLeaderboard::where('period_date', $periodDate)
                ->where('player_name', $playerName)
                ->where('ip_address', $ip)
                ->first();
        }

        $savedRecord = null;
        $isImprovement = false;

        if ($existing) {
            if ($computed['total_score'] >= $existing->total_score) {
                // Skor baru lebih tinggi atau sama: perbarui rekor dan nama jika ada perubahan
                $existing->update([
                    'player_name' => $playerName,
                    'player_organization' => $playerOrg ?: $existing->player_organization,
                    'total_score' => $computed['total_score'],
                    'quiz_score' => $computed['quiz_score'],
                    'quiz_correct_count' => $computed['quiz_correct_count'],
                    'word1_score' => $computed['word1_score'],
                    'word1_attempts' => $computed['word1_attempts'],
                    'word2_score' => $computed['word2_score'],
                    'word2_attempts' => $computed['word2_attempts'],
                    'speed_bonus' => $computed['speed_bonus'],
                    'retry_penalty' => $computed['retry_penalty'],
                    'retry_count' => $computed['retry_count'],
                    'duration_seconds' => $computed['duration_seconds'],
                ]);
                $savedRecord = $existing;
                $isImprovement = true;
            } else {
                // Skor baru lebih rendah: JANGAN downgrade skor! Pertahankan skor tertinggi yang sah,
                // cukup update nama pemain jika ada perubahan nama/alias
                $existing->update([
                    'player_name' => $playerName,
                    'player_organization' => $playerOrg ?: $existing->player_organization,
                ]);
                $savedRecord = $existing;
            }
        } else {
            $savedRecord = GameLeaderboard::create([
                'period_date' => $periodDate,
                'player_name' => $playerName,
                'player_organization' => $playerOrg,
                'total_score' => $computed['total_score'],
                'quiz_score' => $computed['quiz_score'],
                'quiz_correct_count' => $computed['quiz_correct_count'],
                'word1_score' => $computed['word1_score'],
                'word1_attempts' => $computed['word1_attempts'],
                'word2_score' => $computed['word2_score'],
                'word2_attempts' => $computed['word2_attempts'],
                'speed_bonus' => $computed['speed_bonus'],
                'retry_penalty' => $computed['retry_penalty'],
                'retry_count' => $computed['retry_count'],
                'duration_seconds' => $computed['duration_seconds'],
                'device_fingerprint' => $fingerprint,
                'ip_address' => $ip,
            ]);
        }

        // Hitung peringkat posisi pemain saat ini
        $rank = GameLeaderboard::where('period_date', $periodDate)
            ->where(function ($q) use ($savedRecord) {
                $q->where('total_score', '>', $savedRecord->total_score)
                  ->orWhere(function ($q2) use ($savedRecord) {
                      $q2->where('total_score', '=', $savedRecord->total_score)
                         ->where('duration_seconds', '<', $savedRecord->duration_seconds);
                  })
                  ->orWhere(function ($q3) use ($savedRecord) {
                      $q3->where('total_score', '=', $savedRecord->total_score)
                         ->where('duration_seconds', '=', $savedRecord->duration_seconds)
                         ->where('created_at', '<', $savedRecord->created_at);
                  });
            })
            ->count() + 1;

        return response()->json([
            'success' => true,
            'message' => $isImprovement
                ? 'Rekor skormu berhasil diperbarui di Papan Peringkat!'
                : 'Skormu berhasil dicatat di Papan Peringkat!',
            'rank' => $rank,
            'is_top_3' => ($rank <= 3),
            'is_top_10' => ($rank <= 10),
            'total_score' => $savedRecord->total_score,
            'score_details' => [
                'total_score' => $savedRecord->total_score,
                'quiz_score' => $savedRecord->quiz_score,
                'quiz_correct_count' => $savedRecord->quiz_correct_count,
                'word1_score' => $savedRecord->word1_score,
                'word1_attempts' => $savedRecord->word1_attempts,
                'word2_score' => $savedRecord->word2_score,
                'word2_attempts' => $savedRecord->word2_attempts,
                'speed_bonus' => $savedRecord->speed_bonus,
                'retry_penalty' => $savedRecord->retry_penalty,
                'retry_count' => $savedRecord->retry_count,
                'duration_seconds' => $savedRecord->duration_seconds,
            ],
            'player_name' => $savedRecord->player_name,
            'player_organization' => $savedRecord->player_organization,
        ]);
    }
}
