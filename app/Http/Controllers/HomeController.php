<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            // Check user role and redirect accordingly
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->hasRole('Player')) {
                return redirect()->route('user.dashboard');
            }
            
            // Fallback to user dashboard for other roles
            return view('user.dashboard');
        } else {
            // User is not logged in, show welcome page
            return view('welcome');
        }
    }
}
