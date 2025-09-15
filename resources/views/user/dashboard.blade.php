@extends('user_layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Welcome back, {{ Auth::user()->name ?? Auth::user()->user_name }}!</h1>
                <div class="text-muted">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Dashboard Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-primary mb-3">
                        <i class="bi bi-person-circle fs-1"></i>
                    </div>
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text text-muted">Manage your account information</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">View Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-success mb-3">
                        <i class="bi bi-cart-check fs-1"></i>
                    </div>
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text text-muted">Track your orders</p>
                    <a href="#" class="btn btn-outline-success btn-sm">View Orders</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-warning mb-3">
                        <i class="bi bi-heart fs-1"></i>
                    </div>
                    <h5 class="card-title">Wishlist</h5>
                    <p class="card-text text-muted">Your saved items</p>
                    <a href="#" class="btn btn-outline-warning btn-sm">View Wishlist</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-info mb-3">
                        <i class="bi bi-gear fs-1"></i>
                    </div>
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text text-muted">Account preferences</p>
                    <a href="#" class="btn btn-outline-info btn-sm">Settings</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-person-plus text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Account Created</h6>
                                    <p class="mb-1 text-muted">Welcome to our platform!</p>
                                    <small class="text-muted">{{ Auth::user()->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-box-arrow-in-right text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Last Login</h6>
                                    <p class="mb-1 text-muted">You successfully logged in</p>
                                    <small class="text-muted">{{ now()->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
