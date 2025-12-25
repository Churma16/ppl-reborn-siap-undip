<?php

namespace App\Enums;

enum SemesterStatusAktif: int
{
    case AKTIF = 1;
    case TIDAK_AKTIF = 0;

    public function label(): string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::TIDAK_AKTIF => 'Tidak Aktif',
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::TIDAK_AKTIF => 'danger',
        };
    }
}
