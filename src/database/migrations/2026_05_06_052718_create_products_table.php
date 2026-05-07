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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('brand_id')->index();
            $table->unsignedBigInteger('category_id')->index();

            $table->string('name')->index();
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->decimal('price', 12, 2)->index();
            $table->integer('stock')->default(0);

            $table->string('image')->nullable();

            $table->decimal('star', 2, 1)->default(5.0); // vd: 4.5 sao
            $table->integer('review_count')->default(0); // số lượt review

            $table->boolean('status')->default(1)->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};