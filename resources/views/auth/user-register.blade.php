@extends('user_layouts.master')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.register') }}">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   type="text" 
                                   name="name" 
                                   placeholder="Enter your full name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus>
                            <label for="name">Full Name</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('user_name') is-invalid @enderror" 
                                   id="user_name" 
                                   type="text" 
                                   name="user_name" 
                                   placeholder="P0101" 
                                   value="{{ old('user_name') }}" 
                                   required 
                                   autocomplete="user_name">
                            <label for="user_name">Username</label>
                            @error('user_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   type="email" 
                                   name="email" 
                                   placeholder="name@example.com" 
                                   value="{{ old('email') }}" 
                                   autocomplete="email">
                            <label for="email">Email address (Optional)</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   type="tel" 
                                   name="phone" 
                                   placeholder="Enter your phone number" 
                                   value="{{ old('phone') }}" 
                                   autocomplete="tel">
                            <label for="phone">Phone Number (Optional)</label>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           type="password" 
                                           name="password" 
                                           placeholder="Create a password" 
                                           required 
                                           autocomplete="new-password">
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" 
                                           id="password_confirmation" 
                                           type="password" 
                                           name="password_confirmation" 
                                           placeholder="Confirm password" 
                                           required 
                                           autocomplete="new-password">
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" 
                                   type="checkbox" 
                                   name="terms" 
                                   required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a>
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">
                        <a href="{{ route('login') }}">Have an account? Go to login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
