<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductTemplateExport implements FromArray, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        $rows = [
            ['Tên sản phẩm', 'Giá', 'Tồn kho', 'Mô tả'],
        ];

        $products = Product::latest()
            ->take(3)
            ->get([
                'name',
                'price',
                'stock',
                'description'
            ]);

        foreach ($products as $product) {
            $rows[] = [
                $product->name,
                $product->price,
                $product->stock,
                $product->description,
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        $sheet->freezePane('A2');

        $sheet->setAutoFilter('A1:D4');
    }
}