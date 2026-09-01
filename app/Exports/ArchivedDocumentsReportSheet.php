<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ArchivedDocumentsReportSheet implements FromArray, WithTitle, WithStyles
{
    protected $title;
    protected $data;

    public function __construct($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        // Excel sheet names are limited to 31 characters
        return substr($this->title, 0, 31);
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row (first row)
        if (count($this->data) > 0) {
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A8A'], // Dark blue
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]);
        }
        
        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        return [];
    }
}
