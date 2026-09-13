<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'name' => 'Agus Haryanto',
                'password' => Hash::make('123456'),
                'role' => 'guru_mapel',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sekretaris@gmail.com'],
            [
                'name' => 'Sekretaris Kelas',
                'password' => Hash::make('123456'),
                'role' => 'sekretaris',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Doni Saputra',
                'password' => Hash::make('123456'),
                'role' => 'siswa',
            ]
        );

        User::updateOrCreate(
            ['email' => 'bk@gmail.com'],
            [
                'name' => 'Ibu Rahmawati (Guru BK)',
                'password' => Hash::make('123456'),
                'role' => 'guru_bk',
            ]
        );

        User::updateOrCreate(
            ['email' => 'piket@gmail.com'],
            [
                'name' => 'Pak Hendra (Guru Piket)',
                'password' => Hash::make('123456'),
                'role' => 'guru_piket',
            ]
        );
    }
}
