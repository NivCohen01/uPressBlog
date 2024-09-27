@extends('layouts.auth')

@section('content')
<section class="p-3 p-md-4 p-xl-5 vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="p-3 p-md-4 p-xl-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('imgs/upress-logo.png') }}" alt="" width="144" height="40">
                    </div>
                    <h3 class="mt-5 text-center">Login</h3>
                    <form action="{{ route('login.submit') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                <label for="email" class="form-label">Email address</label>
                            </div>
                            @error('email')
                                <div class="text-danger mx-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                                <label for="password" class="form-label">Password</label>
                            </div>
                            @error('password')
                                <div class="text-danger mx-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid my-4">
                            <button type="submit" class="btn btn-primary rounded-pill">Login</button>
                        </div>
                    </form>
                    <hr class="border-secondary-subtle">
                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row align-items-end align-items-md-center justify-content-md-end">
                        <a class="link-secondary text-decoration-none" href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
