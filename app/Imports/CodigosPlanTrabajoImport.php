<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CodigosPlanTrabajoImport implements ToCollection
{
    public function collection(Collection $rows)
    {
         return $rows;
        // foreach ($rows as $row) 
        // {
            
        // }
    }
}
