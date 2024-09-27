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
                        <h3 class="mt-5 text-center">Register</h3>
                        <form action="{{ route('register.submit') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="" required>
                                    <label for="name" class="form-label">Name <span class="required-mark">*</span></label>
                                </div>
                                @error('name')
                                    <div class="text-danger mx-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                                    <label for="email" class="form-label">Email Address <span class="required-mark">*</span></label>
                                </div>
                                @error('email')
                                    <div class="text-danger mx-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="************" required>
                                    <label for="password" class="form-label">Password <span class="required-mark">*</span></label>
                                </div>
                                @error('password')
                                    <div class="text-danger mx-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="************" required>
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="required-mark">*</span></label>
                                </div>
                            </div>
                            <div class="d-grid my-4">
                                <button type="submit" class="btn btn-primary rounded-pill">Register</button>
                            </div>
                        </form>
                        <hr class="border-secondary-subtle">
                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row align-items-end align-items-md-center justify-content-md-end">
                            <a class="link-secondary text-decoration-none" href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
