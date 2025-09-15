<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Enums\UserType;

class UserAuthController extends Controller
{
    private const PLAYER_ROLE = 2;
    
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('user_name', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Check if user has Player role, redirect to user dashboard
            if (Auth::user()->hasRole('Player')) {
                return redirect()->intended(route('user.dashboard'))
                    ->with('success', 'Welcome back! You have been successfully logged in.');
            }
            
            // For other roles, redirect to home
            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back! You have been successfully logged in.');
        }

        return redirect()->back()
            ->with('error', 'The provided credentials do not match our records.')
            ->withInput($request->except('password'));
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.user-register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|unique:users,user_name',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => ['required', 'confirmed', Password::min(6)],
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $user = User::create([
            'name' => $request->name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_changed_password' => 1, // Set to 1 since they just set it
            'type' => UserType::Player,
        ]);

            $user->roles()->sync(self::PLAYER_ROLE);


        // Assign default role if you have role system
        // $user->assignRole('user'); // Uncomment if you have roles

        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('success', 'Account created successfully! Welcome to our platform.');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.user-forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // For now, just show a success message
        // In a real application, you would send an email with reset link
        return redirect()->back()
            ->with('status', 'If an account with that email exists, we have sent a password reset link.');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been successfully logged out.');
    }
}
