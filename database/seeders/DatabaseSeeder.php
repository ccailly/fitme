<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Community;
use App\Models\CommunityMembers;
use App\Models\CommunitySports;
use App\Models\Event;
use App\Models\EventParticipants;
use App\Models\EventPosts;
use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostLikes;
use App\Models\Sport;
use App\Models\User;
use App\Models\UserSports;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        Sport::factory(20)->create();

        UserSports::factory(150)->create();

        Community::factory(50)->create();
        CommunitySports::factory(70)->create();
        CommunityMembers::factory(300)->create();

        Event::factory(150)->create();
        Post::factory(300)->create();

        EventPosts::factory(200)->create();
        EventParticipants::factory(300)->create();

        PostLikes::factory(1000)->create();
        PostComments::factory(50)->create();
    }
}
