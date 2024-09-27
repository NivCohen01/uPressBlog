<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ExternalPostsController extends Controller
{
    public function index()
    {
        $postsResponse = Http::withoutVerifying()->get('https://jsonplaceholder.typicode.com/posts');
        $usersResponse = Http::withoutVerifying()->get('https://jsonplaceholder.typicode.com/users');

        if ($postsResponse->ok() && $usersResponse->ok()) {
            $posts = $postsResponse->json();
            $users = $usersResponse->json();

            $userMap = [];
            foreach ($users as $user) {
                $userMap[$user['id']] = $user;
            }

            return view('external-posts.index', compact('posts', 'userMap'));
        } else {
            return redirect()->back()->with('error', 'Failed to fetch data from JSONPlaceholder');
        }
    }
    
    public function show($id)
    {
        $postResponse = Http::withoutVerifying()->get("https://jsonplaceholder.typicode.com/posts/{$id}");
        $usersResponse = Http::withoutVerifying()->get('https://jsonplaceholder.typicode.com/users');

        if ($postResponse->ok() && $usersResponse->ok()) {
            $post = $postResponse->json();
            $users = $usersResponse->json();

            $user = collect($users)->firstWhere('id', $post['userId']);

            return view('external-posts.show', compact('post', 'user'));
        } else {
            return redirect()->back()->with('error', 'Failed to fetch the post data from JSONPlaceholder');
        }
    }

}
