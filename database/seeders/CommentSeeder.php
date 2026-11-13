<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();

        Post::where('is_published', true)
            ->where('id', '!=', $pinnedPost->id)
            ->each(function (Post $post) use ($users): void {
                for ($comment = 0; $comment < random_int(0, 2); $comment++) {
                    Comment::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        $lola = $users->firstWhere('email', 'lola.ang@bulletin.test');

        $pinnedPost->comments()->createMany([
            [
                'user_id' => $lola->id,
                'body' => 'Lola Ang says this is a wonderful community activity.',
            ],
            [
                'user_id' => $users->random()->id,
                'body' => 'I will join the clean-up drive.',
            ],
            [
                'user_id' => $users->random()->id,
                'body' => 'Thank you for organizing this event.',
            ],
        ]);
    }
}
