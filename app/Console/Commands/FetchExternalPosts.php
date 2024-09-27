<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use Carbon\Carbon;

class FetchExternalPosts extends Command
{
    protected $signature = 'fetch:external-posts';

    protected $description = 'Fetch posts from the JSONPlaceholder API and save them to our database';

    public function handle()
    {
        $this->info('Fetching posts from JSONPlaceholder...');

        $response = Http::withoutVerifying()->get('https://jsonplaceholder.typicode.com/posts');
        $users = Http::withoutVerifying()->get('https://jsonplaceholder.typicode.com/users');

        if ($response->ok() && $users->ok()) {
            $posts = $response->json();

            foreach ($posts as $post) {
                $contentJson = json_encode([
                    ['type' => 'text', 'content' => $post['body']]
                ]);


                Post::create([
                    'title' => $post['title'],
                    'content' => $contentJson,
                    'user_id' => NULL, // NULL to mark its from an external source in DB
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $this->info('Posts have been successfully fetched and saved.');
        } else {
            $this->error('Failed to fetch data from JSONPlaceholder.');
        }
    }
}
