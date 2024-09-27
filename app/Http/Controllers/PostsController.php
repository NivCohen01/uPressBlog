<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Helpers\ContentParser;

class PostsController extends Controller
{

    public function index()
    {
        
        $posts = Post::with('user')->paginate(3);
    
        foreach ($posts as $post) {
            $parsedContent = json_decode($post->content, true);
    
            if ($parsedContent) {
                $post->preview = ContentParser::createHTMLElement($parsedContent[0]);
            }
        }
    
        return view('posts.index', compact('posts'));
    }
    
    
    // Show create post form
    public function create()
    {
        return view('posts.create');
    }

    // Store the post (just a placeholder)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'json_content' => 'required|string' // We're storing the JSON stringified content
        ]);
    
        // Create the post and store in the database
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('json_content'); // Save JSON string
        $post->user_id = auth()->id(); // Assuming the user is authenticated
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);

        $parsedContent = json_decode($post->content, true);

        return view('posts.show', compact('post', 'parsedContent'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.create', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'json_content' => 'required|string' 
        ]);
    
        $post->title = $request->input('title');
        $post->content = $request->input('json_content'); 
        $post->user_id = auth()->id();
        $post->updated_at = now();
        $post->save(); 
    
        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

        
    
}
