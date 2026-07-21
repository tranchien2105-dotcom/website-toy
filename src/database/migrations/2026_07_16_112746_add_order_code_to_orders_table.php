<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code')->nullable()->unique()->after('id');
        });

        DB::table('orders')->orderBy('id')->get()->each(function ($order) {
            DB::table('orders')
                ->where('id', $order->id)
                ->update([
                    'order_code' => 'DH' . str_pad($order->id, 6, '0', STR_PAD_LEFT)
                ]);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_code');
        });
    }
};