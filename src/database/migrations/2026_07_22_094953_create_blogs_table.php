<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();

            $table->string('image')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description');

            $table->string('created_by');
            $table->string('category');
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();

            $table->date('date');

            $table->integer('comment')->default(0);

            // Không dùng enum
            $table->string('status')->default('Draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};