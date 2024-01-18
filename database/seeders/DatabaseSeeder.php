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
        User::factory(50)->create();

        Sport::factory(10)->create();

        UserSports::factory(20)->create();

        Community::factory(10)->create();
        CommunitySports::factory(15)->create();
        CommunityMembers::factory(50)->create();

        Event::factory(10)->create();
        Post::factory(30)->create();

        EventPosts::factory(10)->create();
        EventParticipants::factory(30)->create();

        PostLikes::factory(100)->create();
        PostComments::factory(30)->create();
    }
}
