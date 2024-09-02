<?php

namespace App\Exports;

use App\Models\Estacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstacionExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Estacion::select('nombre', 'empresa', 'localidad', 'direccion')->get();
    }
    public function headings(): array
    {
        return ['nombre', 'empresa', 'localidad', 'direccion'];
    }
}
