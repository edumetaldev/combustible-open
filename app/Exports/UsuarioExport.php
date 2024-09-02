<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuarioExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('dni as DNI','nombre as Nombre','rol','created_at as Registro','email as Correo-e','nombre as cuenta','oficina')->get();
    }

    public function headings(): array
    {
        return ['DNI', 'Nombre', 'Rol', 'Registro', 'Correo-e', 'cuenta', 'oficina'];
    }
}
