<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::count() === 0 ? 'admin' : 'user', 
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function dashboard() {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalNotes' => Note::count(),
            'myNotesCount' => Auth::user()->notes()->count(),
            'thisMonthNtes' => Note::whereMonth('created_at', now()->month)->count(),
        ]);
    }

    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle File Upload
        if ($request->hasFile('profile_picture')) {
            if (!file_exists(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('avatars'), $imageName);
            
            // Save path to DB
            $user->profile_picture = 'avatars/' . $imageName;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('toast_success', 'Profile updated successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}