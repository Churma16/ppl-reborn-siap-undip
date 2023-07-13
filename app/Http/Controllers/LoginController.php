<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
        ]);
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            if (auth()->user()->role == '1') {
                return redirect()->intended('/dashboard-admin');
            }
            if (auth()->user()->role == '2') {
                return redirect()->intended('/dashboard-departemen');
            }
            if (auth()->user()->role == '3') {
                // return redirect()->intended('/dashboard-dosen/'.auth()->user()->nip_nim);
                return redirect()->intended('/dashboard-dosen');
            }
            if (auth()->user()->role == '4') {
                return redirect()->intended('/dashboard-mhs');
            }
        }

        return back()->withInput()->withErrors(['loginError' => 'Username or password is incorrect!']);
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
