@extends('layouts.app')

@section('title', $post['title'])

@section('content')
    <h1>{{ $post['title'] }}</h1>
    <small>By {{ $user['name'] }} ({{ $user['email'] }})</small>
    <p>{{ $post['body'] }}</p>

    <div class="mt-4">
        <a href="{{ route('external-posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>
@endsection
