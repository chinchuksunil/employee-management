<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class LoginController extends Controller
{
    public function showLoginForm($role = 'user')
    {
        if (!in_array($role, ['admin', 'user'])) {
            abort(404);
        }
        return view('login.login', compact('role'));
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,user'],
        ]);

        $login_credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($login_credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (($user->role == 1 && $request->role == 'admin') ||
                ($user->role == 0 && $request->role == 'user')) {
                if ($user->role == 1) {
                    session()->flash('success', 'Welcome back, Admin ' . $user->name . '!');
                    return redirect()->route('dashboard');
                } else {
                    session()->flash('success', 'Welcome back, ' . $user->name . '!');
                    return redirect()->route('dashboard');
                }
            }


            Auth::logout();
            return redirect()->route('login', $request->role)
                  ->with('error', 'You are not allowed to login.')
                  ->onlyInput('email');

        }

        return redirect()->route('login', $request->role)
                ->with('error', 'Invalid email or password.')
                ->onlyInput('email');
    }

    public function dashboard()
    {
        $totalEmployees = Employee::count();

        $thisMonthEmployees = Employee::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $thisMonthJoinEmployees = Employee::whereMonth('date_of_join', now()->month)
            ->whereYear('date_of_join', now()->year)
            ->count();

        $recentEmployees = Employee::latest()->take(5)->get();

        return view('dashboard', compact(
                'totalEmployees',
                'thisMonthEmployees',
                'thisMonthJoinEmployees',
                'recentEmployees'
            ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login', ['role' => 'user']);

}




}
