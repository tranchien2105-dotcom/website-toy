<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize
{
    public function collection()
    {
        return User::select('id', 'name', 'email')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Email',
        ];
    }

    // 🎨 Custom style
    public function styles(Worksheet $sheet)
    {
        // Style header (row 1)
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);

        // Border toàn bảng
        $sheet->getStyle('A1:C' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );

        return [];
    }

    // Custom độ rộng cột
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 30,
        ];
    }
}