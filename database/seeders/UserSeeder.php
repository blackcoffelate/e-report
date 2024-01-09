<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
          'nama_lengkap' => 'Administrator',
          'email' => 'admin@mail.com',
          'password' => 'demo',
          'telepon' => '0821xxxxxxxxx',
        ]);

        $admin->assignRole('admin');
    }
}
