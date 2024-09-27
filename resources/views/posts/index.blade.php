@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <h1>All Posts</h1>

    @foreach($posts as $post)
        <div class="card mb-4">
            <div class="card-header">
                <h2>
                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                </h2>
                <small>By {{ $post->user->name ?? 'External source' }} on {{ $post->created_at->format('d M, Y') }}</small>
            </div>
            <div class="card-body">
                <!-- Render the post preview -->
                {!! $post->preview !!}
            </div>
            <div class="card-footer">
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read More</a>

                @if(Auth::check() && Auth::id() == $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Pagination Links -->
    <div class="d-flex justify-content-end">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection
