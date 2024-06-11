<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
                'email' => 'user@example.com',
                'name' => 'user',
                'password' => '$2y$10$sle.82qcGEFdsHuS86sQC.gjgyVG.iFhTnuuC6X2KD4IJI367Jhfm',
            ]
        );

        User::updateOrCreate([
                'email' => 'admin@c.l',
                'name' => 'admin1',
                'password' => 'admin1',
                'role' => 'admin'
            ]
        );
    }
}
