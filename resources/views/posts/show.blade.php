@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <small>Author: {{ $post->user->name ?? "External source"}}</small> <br>
    <small>Created at: {{ $post->created_at->format('d-m-Y H:i') }}</small> <br>
    <small>Last modified: {{ $post->updated_at->format('d-m-Y H:i') }}</small> <br>

    @if(Auth::check() && (Auth::id() == $post->user_id || $post->user_id == NULL))
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>

        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Post</button>
        </form>
    @endif

    <div class="post-content mt-4">
        @php
            use App\Helpers\ContentParser;

            $parsedContent = json_decode($post->content, true);
            if ($parsedContent) {
                foreach ($parsedContent as $block) {
                    echo ContentParser::createHTMLElement($block);
                }
            } else {
                echo '<p>Unable to render post content.</p>';
            }
        @endphp
        <div class="mt-4">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
        </div>
    </div>
@endsection
