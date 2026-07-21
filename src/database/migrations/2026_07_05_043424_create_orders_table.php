<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->string('fullname');

            $table->string('phone', 20);

            $table->string('email')->nullable();

            $table->string('address');

            $table->text('note')->nullable();

            $table->enum('payment_method', [
                'cod',
                'bank',
                'vnpay'
            ]);

            $table->decimal('subtotal', 12, 2);

            $table->decimal('shipping', 12, 2)->default(0);

            $table->decimal('discount', 12, 2)->default(0);

            $table->decimal('total', 12, 2);

            $table->enum('status', [
                'pending',
                'confirmed',
                'shipping',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
