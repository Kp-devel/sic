<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;//mantener los ceros
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Http\Request;
use App\Reporte;

class TablaConfirmacionesSheet implements FromCollection, WithHeadings,WithColumnFormatting,WithStyles,WithStrictNullComparison
{
    
    use Exportable;

    

    public function __construct(Request $rq)
    {
        $this->rq = $rq;
        $this->cantRegistros=0;
    }

    public function collection()
    {
        ini_set('memory_limit', '-1');
        $res=Reporte::generarReporteConfirmaciones($this->rq);
        $this->cantRegistros=count($res);
        // $tabla=array();
        // for($i=0;count($res);$i++){
        //     array_push($tabla,$res[$i]);
        // }
        return  collect($res);
    }

    public function headings(): array
    {
        return [
            "Fecha",
            "Cantidad",
            "Monto"
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            // 'A' => '@',
            'A' => 'dd/mm/yy',
            'B' => '0',
            'C' => '#,##0.00'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Y1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Y1')->getFont()->getColor()->setARGB("f5f5f5");
        $background = array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'startColor' => array('argb' => '04407d'),
            )
        );
        $sheet ->getStyle('A1:Y1')->applyFromArray($background);

        $borders = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );
        for($i=0;$i<=$this->cantRegistros;$i++){
            $sheet ->getStyle('A'.$i)->applyFromArray($borders);
            $sheet ->getStyle('B'.$i)->applyFromArray($borders);
            $sheet ->getStyle('C'.$i)->applyFromArray($borders);
            $sheet ->getStyle('D'.$i)->applyFromArray($borders);
        }
    }
}
