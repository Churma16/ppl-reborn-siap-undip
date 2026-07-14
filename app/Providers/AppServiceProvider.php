<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('dashboard-dosen.partials.sidenav', function ($view) {
            if (auth()->check()) {
                $dosen = \App\Models\Dosen::where('nip', auth()->user()->nip_nim)->first();
                if ($dosen) {
                    $mhsNims = $dosen->getMahasiswaBimbinganAttribute();
                    $view->with([
                        'verifikasiIrsCount' => \App\Models\IRS::whereIn('mahasiswa_nim', $mhsNims)->where('status_konfirmasi', 'Belum Dikonfirmasi')->count(),
                        'verifikasiKhsCount' => \App\Models\KHS::whereIn('mahasiswa_nim', $mhsNims)->where('status_konfirmasi', 'Belum Dikonfirmasi')->count(),
                        'verifikasiPklCount' => \App\Models\PKL::whereIn('mahasiswa_nim', $mhsNims)->where('status_konfirmasi', 'Belum Dikonfirmasi')->count(),
                        'verifikasiSkripsiCount' => \App\Models\Skripsi::whereIn('mahasiswa_nim', $mhsNims)->where('status_konfirmasi', 'Belum Dikonfirmasi')->count(),
                    ]);
                    return;
                }
            }
            $view->with([
                'verifikasiIrsCount' => 0,
                'verifikasiKhsCount' => 0,
                'verifikasiPklCount' => 0,
                'verifikasiSkripsiCount' => 0,
            ]);
        });
    }
}
