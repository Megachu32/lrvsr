<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Needed for password hashing
use App\Models\Role;
use App\Models\User;
use App\Models\Community;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREATE ROLES
        $adminRole = Role::create([
            'role_name' => 'Admin',
            'description' => 'Super User'
        ]);

        $memberRole = Role::create([
            'role_name' => 'Member',
            'description' => 'Regular User'
        ]);

        // 2. CREATE USERS
        // User 1: The Admin
        $admin = User::create([
            'username' => 'AdminUser',
            'email' => 'admin@example.com',
            'password_hash' => Hash::make('password123'), // Encrypted password
            'role_id' => $adminRole->role_id,
            'avatar_url' => 'https://via.placeholder.com/150'
        ]);

        // User 2: A Regular Member
        $member = User::create([
            'username' => 'JohnDoe',
            'email' => 'john@example.com',
            'password_hash' => Hash::make('password123'),
            'role_id' => $memberRole->role_id,
            'avatar_url' => 'https://via.placeholder.com/150'
        ]);

        // 3. CREATE A COMMUNITY
        $techCommunity = Community::create([
            'name' => 'r/LaravelHelp',
            'description' => 'A place to ask questions about code.',
            'creator_id' => $admin->user_id
        ]);

        // 4. CREATE A POST (By the Member, in the Tech Community)
        $post = Post::create([
            'user_id' => $member->user_id,
            'community_id' => $techCommunity->community_id,
            'title' => 'How do I use Seeders?',
            'content' => 'I am trying to populate my database. Help!'
        ]);

        // 5. CREATE A COMMENT (Admin replies to the Member)
        Comment::create([
            'post_id' => $post->post_id,
            'user_id' => $admin->user_id,
            'parent_comment_id' => null, // Top level comment
            'content' => 'You just run php artisan db:seed!'
        ]);

        // 6. CREATE A VOTE (Admin likes the post)
        Vote::create([
            'user_id' => $admin->user_id,
            'post_id' => $post->post_id,
            'comment_id' => null,
            'vote_type' => 1 // Upvote
        ]);
        
        // 7. SUBSCRIBE MEMBER TO COMMUNITY
        Subscription::create([
            'user_id' => $member->user_id,
            'community_id' => $techCommunity->community_id
        ]);
    }
}