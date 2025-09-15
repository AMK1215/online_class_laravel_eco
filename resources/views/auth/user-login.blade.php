@extends('user_layouts.master')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('user_name') is-invalid @enderror" 
                                   id="user_name" 
                                   type="text" 
                                   name="user_name" 
                                   placeholder="P0101" 
                                   value="{{ old('user_name') }}" 
                                   required 
                                   autocomplete="user_name" 
                                   autofocus>
                            <label for="user_name">Username</label>
                            @error('user_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   type="password" 
                                   name="password" 
                                   placeholder="Password" 
                                   required 
                                   autocomplete="current-password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   id="remember" 
                                   type="checkbox" 
                                   name="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Password
                            </label>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">
                        <a href="{{ route('register') }}">Need an account? Sign up!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
