<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. [CREATION] We define the variable '$mainUser' here.
        $mainUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. We create 10 other random users
        $users = User::factory(10)->create();

        // 3. [USAGE] We use the '$mainUser' variable we created in Step 1.
        // We pass the ID into the create() array to link these posts to our Test User.
        Post::factory(5)->create([
            'user_id' => $mainUser->id, 
        ]);

        // 4. Create random posts for the other users
        $users->each(function ($user) use ($users) {
            Post::factory(3)->create([
                'user_id' => $user->id,
            ])->each(function ($post) use ($users) {
                Comment::factory(rand(1, 3))->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
            });
        });
    }
}