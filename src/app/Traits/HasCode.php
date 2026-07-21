<?php

namespace App\Traits;

trait HasCode
{
    /**
     * Sinh mã theo prefix.
     * Ví dụ:
     * DH000001
     * SP000001
     */
    public static function generateCode(string $prefix, int $id): string
    {
        return $prefix . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}