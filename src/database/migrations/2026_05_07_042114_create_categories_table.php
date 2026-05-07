<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            // category cha
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->text('description')->nullable();

            // trạng thái
            $table->tinyInteger('status')->default(1)
                ->comment('1: active, 0: inactive');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};