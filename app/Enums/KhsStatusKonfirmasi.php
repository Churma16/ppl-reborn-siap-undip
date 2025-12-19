<?php
namespace App\Enums;

enum KhsStatusKonfirmasi: string{
    case Dikonfirmasi = 'Dikonfirmasi';
    case Ditolak = 'Ditolak';
    case Belum_Dikonfirmasi = 'Belum Dikonfirmasi';

    public function color(): string{
        return match($this){
            self::Dikonfirmasi => 'success',
            self::Ditolak => 'danger',
            self::Belum_Dikonfirmasi => 'warning',
        };
    }
}
