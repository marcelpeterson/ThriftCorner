<?php

// database/seeders/NewsArticleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsArticle;
use App\Models\User;

class NewsArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        NewsArticle::create([
            'title' => 'Welcome to the ThriftCorner News Portal!',
            'slug' => 'welcome-to-the-thriftcorner-news-portal',
            'content' => 'This is the first news article on our new portal. We are excited to share updates and news with you.',
            'user_id' => 5,
        ]);
    }
}