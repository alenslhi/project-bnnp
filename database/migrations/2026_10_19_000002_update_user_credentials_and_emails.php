<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update email dan password untuk akun Super Admin
        DB::table('users')
            ->where('role', 'super_admin')
            ->update([
                'email'    => 'superadmin@bnn.id',
                'password' => Hash::make('12345678'),
            ]);

        // 2. Update email dan password untuk akun Admin pertama
        $firstAdmin = DB::table('users')
            ->where('role', 'admin')
            ->orderBy('id', 'asc')
            ->first();

        if ($firstAdmin) {
            DB::table('users')
                ->where('id', $firstAdmin->id)
                ->update([
                    'email'    => 'admin@bnn.id',
                    'password' => Hash::make('12345678'),
                ]);
        }

        // 3. Update password untuk semua akun admin jika ada lebih dari 1
        DB::table('users')
            ->where('role', 'admin')
            ->where('email', '!=', 'admin@bnn.id')
            ->update([
                'password' => Hash::make('12345678'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('role', 'super_admin')
            ->update([
                'email' => 'superadmin@bnnp-sulteng.go.id',
            ]);

        DB::table('users')
            ->where('role', 'admin')
            ->where('email', 'admin@bnn.id')
            ->update([
                'email' => 'admin@bnnp-sulteng.go.id',
            ]);
    }
};
