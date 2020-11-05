<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Reporte;

class GestionesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    
    use Exportable;

    public function __construct(Request $rq)
    {
        $this->rq = $rq;
    }

    public function collection()
    {
        $res=Reporte::reporteGeneralGestiones($this->rq);
        return  collect($res);
    }

    public function headings(): array
    {
        return [
            '#',
            'User',
            'Date',
        ];
    }
}
