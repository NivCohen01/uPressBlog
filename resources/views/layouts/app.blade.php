<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'uPress Blog')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('imgs/upress-logo.png') }}" alt="Logo" width="100" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link {{ Request::is('posts') ? 'active' : '' }}" data-href="{{ route('posts.index') }}">
                            Posts
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ Request::is('/external-posts') ? 'active' : '' }}" data-href="{{ route('external-posts.index') }}">
                            External Posts
                        </span>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <span class="nav-link {{ Request::is('posts/create') ? 'active' : '' }}" data-href="{{ route('posts.create') }}">
                                Create Post
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="display:inline; cursor: pointer;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @endif
                    @if(!Auth::check())
                        <li class="nav-item">
                            <span class="nav-link" data-href="{{ route('login') }}">
                                Login
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link" data-href="{{ route('register') }}">
                                Register
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @yield('scripts')

    <script>
        // JavaScript to handle navigation using span elements
        $(document).ready(function() {
            $('.nav-link').on('click', function() {
                const targetUrl = $(this).data('href');
                if (targetUrl) {
                    window.location.href = targetUrl;
                }
            });
        });
    </script>
</body>
</html>
