<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            "name" => "Admin Linktree",
            "email" => "adminpemro@unej.ac.id",
            "password" => bcrypt("password")
        ]);
        $admin->assignRole("Admin");
    }
}
