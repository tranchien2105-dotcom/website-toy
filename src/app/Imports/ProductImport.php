<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToCollection, WithValidation
{
    public function collection(Collection $rows)
    {
        // Bỏ header
        $rows->shift();

        DB::transaction(function () use ($rows) {

            foreach ($rows as $row) {

                if (empty(trim($row[0] ?? ''))) {
                    continue;
                }

                Product::create([
                    'name' => trim($row[0]),
                    'slug' => Str::slug($row[0]),
                    'category_id' => 1,
                    'brand_id' => 1,
                    'price' => $row[1],
                    'stock' => $row[2],
                    'description' => !empty($row[3]) ? trim($row[3]) : null,
                    'status' => 1,
                ]);
            }
        });
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required|string|max:255', // name
            '*.1' => 'required|numeric|min:0',  // price
            '*.2' => 'required|integer|min:0',  // stock
            '*.3' => 'nullable|string',         // description
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.0.required' => 'Tên sản phẩm không được để trống.',
            '*.1.required' => 'Giá không được để trống.',
            '*.1.numeric' => 'Giá phải là số.',
            '*.2.required' => 'Tồn kho không được để trống.',
            '*.2.integer' => 'Tồn kho phải là số nguyên.',
        ];
    }
}