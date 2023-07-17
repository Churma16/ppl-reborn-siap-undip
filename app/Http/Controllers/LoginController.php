<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
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
     * Mengautentikasi pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validasi kredensial pengguna
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mencoba untuk melakukan autentikasi pengguna
        if (auth()->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // Mengarahkan pengguna ke halaman yang sesuai berdasarkan peran (role) pengguna
            if (auth()->user()->role == '1') {
                return redirect()->intended('/dashboard-admin');
            }
            if (auth()->user()->role == '2') {
                return redirect()->intended('/dashboard-departemen');
            }
            if (auth()->user()->role == '3') {
                return redirect()->intended('/dashboard-dosen');
            }
            if (auth()->user()->role == '4') {
                return redirect()->intended('/dashboard-mahasiswa');
            }
        }

        return back()->withInput()->withErrors(['loginError' => 'Username or password is incorrect!']);
    }

    /**
     * Melakukan logout pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
