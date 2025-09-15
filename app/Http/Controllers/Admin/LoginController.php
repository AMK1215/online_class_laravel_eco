<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function ShowloginForm()
    {
        return view('auth.login');
    }


    public function login(LoginRequest $request)
    {
        //dd($request->all());
        $user = User::where('user_name', $request->user_name)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials. Please try again.');
        }

        if ($user->is_changed_password == 0) {
            return view('auth.passwords.index', compact('user'));
        }

        if (Auth::attempt($request->only('user_name', 'password'))) {
            // Check for unauthorized roles
            if ($request->user()->hasRole('Player')) {
                abort(403);
            }

            // Log user activity (assuming UserLog model)
            // UserLog::create([
            //     'ip_address' => $request->ip(),
            //     'user_id' => Auth::id(), // Use Auth::id() for logged in user
            //     'user_agent' => $request->userAgent(),
            // ]);

            // Redirect admin to admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.show-login-form')
            ->with('success', 'You have been successfully logged out.');
    }
}
