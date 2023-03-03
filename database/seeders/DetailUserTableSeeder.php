<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailUser;
use Illuminate\Support\Facades\Hash;

class DetailUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_user = [
            [
                'user_id' => 1,
                'photo' => '',
                'role' => 'Website Developer',
                'contact_number' => '08123456789',
                'biography' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'photo' => '',
                'role' => 'Android Developer',
                'contact_number' => '087812412741',
                'biography' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DetailUser::insert($detail_user);
    }
}
