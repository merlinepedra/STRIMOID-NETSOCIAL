<?php

class ContentTableSeeder extends Seeder {

    public function run()
    {
        DB::collection('contents')->delete();

        // Get list of user and group ids
        $groupIds = DB::collection('groups')->lists('_id');
        $userIds = DB::collection('users')->lists('_id');

        $faker = \Faker\Factory::create();

        // Insert 50 elements filled with random data
        for ($x = 1; $x <= 50; $x++)
        {
            // Use static id generated by using first 6 chars of $x hash
            $id = substr(md5($x), 0, 6);

            $randomUser = (string) $userIds[array_rand($userIds)];
            $randomGroup = (string) $groupIds[array_rand($groupIds)];

            Content::create([
                '_id' => $id,
                'created_at' => $faker->dateTimeThisDecade,
                'group_id' => $randomGroup,
                'title' => $faker->sentence(10),
                'description' => $faker->text(200),
                'user_id' => $randomUser,
                'url' => $faker->url,
                'nsfw' => $faker->boolean,
                'eng' => $faker->boolean,
            ]);
        }
    }

}
