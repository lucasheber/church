<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Here you would typically check the credentials against your user model
        // For example:
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard.index')->with('success', 'Login successful!');
        }

        // If authentication fails, redirect back with an error message
        return redirect()->route('login')
            ->withInput($request->only('email'))
            ->withErrors(['message' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function register(): \Inertia\Response
    {
        return Inertia::render('Auth/Register');
    }

    public function registerPost(Request $request): RedirectResponse
    {
        // Validate the registration data
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        return redirect()->route('dashboard.index')->with('success', 'Registration successful!');
    }

    public function forgotPassword(): \Inertia\Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function forgotPasswordPost(Request $request): RedirectResponse
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Here you would typically send a password reset link to the user's email
        // For example:
        // Password::sendResetLink($request->only('email'));

        return redirect()->route('login')->with('success', 'Password reset link sent to your email.');
    }
}
