<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\Category;
use App\Models\CategoryHasPost;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(1000)->create();

        $categories_has_posts = Post::all()
            ->map(function ($item) {
                $category_id = Category::inRandomOrder()->first()->id;
                return [
                    'post_id' => $item->id,
                    'category_id' => $category_id
                ];
            })
            ->toArray();
        CategoryHasPost::insert($categories_has_posts);
    }
}
