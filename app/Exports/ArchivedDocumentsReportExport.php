<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class ArchivedDocumentsReportExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        foreach ($this->data as $sheetName => $sheetData) {
            $sheets[] = new ArchivedDocumentsReportSheet($sheetName, $sheetData);
        }
        
        return $sheets;
    }
}
