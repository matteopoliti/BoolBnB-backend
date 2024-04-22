<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = config('users');

        foreach ($users as $element) {
            User::create([
                'name' => $element['name'],
                'surname' => $element['surname'],
                'email' => $element['email'],
                'password' => Hash::make($element['password']),
                'date_of_birth' => $element['date_of_birth']
            ]);
        }
    }
}
