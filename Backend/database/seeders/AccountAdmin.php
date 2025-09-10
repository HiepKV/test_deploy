<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingAccount = DB::table('accounts')->where('username', 'admin')->first();
        if ($existingAccount) {
            return;
        }

        DB::beginTransaction();
        try {
            $accountId = DB::table('accounts')->insertGetId([
                'id'         => 'admin123',
                'username'   => 'admin',
                'role'       => 'admin',
                'password'   => Hash::make('password123'),
                'memo'       => 'Super admin account',
                'created_at' => now(),
            ]);

            // 2. Gắn thông tin user vào account admin
            DB::table('users')->insert([
                'name'       => 'Admin User',
                'dob'        => '1990-01-01',
                'email'      => 'admin@example.com',
                'account_id' => "admin123",
                'status'     => 'active',
                'phone'      => '0123456789',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // ném lỗi ra để dễ debug
        }
    }
}
