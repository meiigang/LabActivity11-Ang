<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagNames = ['Purok Ang', 'Urgent', 'Libre', 'Schedule', 'Community'];
        $tags = collect($tagNames)->mapWithKeys(
            fn (string $name): array => [$name => Tag::create(['name' => $name])]
        );

        Post::query()->each(function (Post $post) use ($tags): void {
            $post->tags()->sync(
                $tags->random(random_int(1, 3))->pluck('id')->all()
            );
        });

        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();
        $pinnedPost->tags()->sync([
            $tags['Purok Ang']->id,
            $tags['Urgent']->id,
        ]);
    }
}
