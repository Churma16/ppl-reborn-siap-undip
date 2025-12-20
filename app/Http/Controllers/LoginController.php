<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validasi kredensial pengguna
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = $this->authService->authenticate(
            $credentials['username'],
            $credentials['password']);

        // check apakah usernya ada
        if ($user) {
            // dd(auth()->user()->role);
            $request->session()->regenerate();

            $role = auth()->user()->role;

            return match ($role) {
                UserRole::Admin => redirect()->intended('/dashboard-admin'), // Pastikan case-nya sesuai nama di file Enum Anda (misal: Admin/ADMIN)
                UserRole::Departemen => redirect()->intended('/dashboard-departemen'),
                UserRole::Dosen => redirect()->intended('/dashboard-dosen'),
                UserRole::Mahasiswa => redirect()->intended('/dashboard-mahasiswa'),
                default => redirect('/'), // Fallback jika role tidak dikenali
            };

            // Mengarahkan pengguna ke halaman yang sesuai berdasarkan peran (role) pengguna
            // if (auth()->user()->role == '1') {
            //     return redirect()->intended('/dashboard-admin');
            // }
            // if (auth()->user()->role == '2') {
            //     return redirect()->intended('/dashboard-departemen');
            // }
            // if (auth()->user()->role == '3') {
            //     return redirect()->intended('/dashboard-dosen');
            // }
            // if (auth()->user()->role == 4) {
            //     return redirect()->intended('/dashboard-mahasiswa');
            // }
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
