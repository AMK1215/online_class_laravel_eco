@extends('user_layouts.master')

@section('title', 'Forgot Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Forgot Password</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="small mb-3">
                        Enter your email address and we will send you a link to reset your password.
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   type="email" 
                                   name="email" 
                                   placeholder="name@example.com" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus>
                            <label for="email">Email address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="{{ route('login') }}">Back to Login</a>
                            <button class="btn btn-primary" type="submit">Send Reset Link</button>
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
