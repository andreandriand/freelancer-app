<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExperienceUser;

class ExperienceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $experience = [
            [
                'id' => 1,
                'user_detail_id' => 1,
                'experience' => 'Frontend Developer',
                'created_at' => '2021-08-01 00:00:00',
            ],
            [
                'id' => 2,
                'user_detail_id' => 1,
                'experience' => 'Backend Developer',
                'created_at' => '2021-08-01 00:00:00',
            ],
            [
                'id' => 3,
                'user_detail_id' => 1,
                'experience' => 'UI/UX Designer',
                'created_at' => '2021-08-01 00:00:00',
            ],
        ];

        ExperienceUser::insert($experience);
    }
}
