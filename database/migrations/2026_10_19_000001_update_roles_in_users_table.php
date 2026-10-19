<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah sementara kolom role menjadi VARCHAR agar bisa menerima nilai 'admin'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'admin'");
        }

        // 2. Pastikan password Super Admin selalu 'password'
        DB::table('users')
            ->where('role', 'super_admin')
            ->update([
                'password' => Hash::make('password'),
            ]);

        // 3. Satukan akun admin lama menjadi 1 akun admin tunggal
        $firstAdmin = DB::table('users')
            ->whereIn('role', ['admin_rehab', 'admin_brantas', 'admin_cegah', 'admin'])
            ->orderBy('id', 'asc')
            ->first();

        if ($firstAdmin) {
            // Ubah akun pertama menjadi Admin BNNP resmi
            DB::table('users')
                ->where('id', $firstAdmin->id)
                ->update([
                    'name'     => 'Admin BNNP',
                    'email'    => 'admin@bnnp-sulteng.go.id',
                    'password' => Hash::make('password'),
                    'role'     => 'admin',
                ]);

            $targetAdminId = $firstAdmin->id;

            // Alihkan penulis_id materi edukasi dari admin lama lainnya ke admin tunggal ini
            $otherOldAdminIds = DB::table('users')
                ->whereIn('role', ['admin_rehab', 'admin_brantas', 'admin_cegah'])
                ->where('id', '!=', $targetAdminId)
                ->pluck('id')
                ->toArray();

            if (!empty($otherOldAdminIds)) {
                DB::table('edukasis')
                    ->whereIn('penulis_id', $otherOldAdminIds)
                    ->update(['penulis_id' => $targetAdminId]);

                // Hapus akun admin lama yang berlebih agar hanya tersisa 1 akun admin
                DB::table('users')
                    ->whereIn('id', $otherOldAdminIds)
                    ->delete();
            }
        } else {
            // Jika belum ada akun admin sama sekali, buat 1 akun admin
            DB::table('users')->insert([
                'name'       => 'Admin BNNP',
                'email'      => 'admin@bnnp-sulteng.go.id',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Ubah tipe kolom role pada MySQL menjadi ENUM ketat: 'super_admin', 'admin'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin_rehab', 'admin_brantas', 'admin_cegah') NOT NULL DEFAULT 'admin_cegah'");
        }
    }
};
