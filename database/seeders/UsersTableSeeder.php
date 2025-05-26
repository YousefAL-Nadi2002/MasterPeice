<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // إنشاء مشرف النظام
        User::create([
            'name' => 'مشرف النظام',
            'email' => 'admin@chargezone.jo',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        // إنشاء بعض المستخدمين للاختبار
        User::create([
            'name' => 'أحمد محمد',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'سارة خالد',
            'email' => 'sara@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'is_active' => true,
        ]);
    }
} 