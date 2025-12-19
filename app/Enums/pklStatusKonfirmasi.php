<?php
namespace App\Enums;

enum SkripsiStatusKonfirmasi: string {
    case Dikonfirmasi = 'Dikonfirmasi';
    case Ditolak = 'Ditolak';
    case Belum_Dikonfirmasi = 'Belum Dikonfirmasi';
    case Belum_Ambil = 'Belum Ambil';

    public function color(): string {
        return match($this) {
            self::Dikonfirmasi => 'success',
            self::Ditolak => 'danger',
            self::Belum_Dikonfirmasi => 'warning',
            self::Belum_Ambil => 'secondary', // Warna abu-abu
        };
    }

    // Opsional: Helper untuk label yang lebih rapi
    public function label(): string {
        return match($this) {
            self::Belum_Ambil => 'Belum Mengambil',
            default => $this->value,
        };
    }
}
