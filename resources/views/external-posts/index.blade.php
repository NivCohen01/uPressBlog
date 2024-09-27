@extends('layouts.app')

@section('title', 'External Posts')

@section('content')
    <h1>External Posts from JSONPlaceholder</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @foreach($posts as $post)
        <div class="card mb-4">
            <div class="card-header">
                <h2>
                    <a href="{{ route('external-posts.show', $post['id']) }}">{{ $post['title'] }}</a>
                </h2>
                @php
                    $user = $userMap[$post['userId']];
                @endphp
                <small>By {{ $user['name'] }}</small>
            </div>
            <div class="card-body">
                <!-- Display the first 30 words of the body -->
                <p>{{ \Illuminate\Support\Str::words($post['body'], 30, '...') }}</p>
                <a href="{{ route('external-posts.show', $post['id']) }}" class="btn btn-primary">Read More</a>
            </div>
        </div>
    @endforeach
@endsection
