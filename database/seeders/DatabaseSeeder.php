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
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(50)->create();

        Sport::factory(20)->create();

        // UserSports::factory(75)->create();

        // Community::factory(25)->create();
        // CommunitySports::factory(35)->create();
        // CommunityMembers::factory(150)->create();

        // Event::factory(30)->create();
        // Post::factory(75)->create();

        // EventPosts::factory(100)->create();
        // EventParticipants::factory(150)->create();

        // PostLikes::factory(500)->create();
        // PostComments::factory(75)->create();
    }
}
