<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = '1';
    case Departemen = '2';
    case Dosen = '3';
    case Mahasiswa = '4';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Departemen => 'Departemen',
            self::Dosen => 'Dosen',
            self::Mahasiswa => 'Mahasiswa',
        };
    }

    public function mainPage(): string
    {
        return match ($this) {
            self::Admin => '/dashboard-admin',
            self::Departemen => '/dashboard-departemen',
            self::Dosen => '/dashboard-dosen',
            self::Mahasiswa => '/dashboard-mahasiswa',
        };
    }
}
