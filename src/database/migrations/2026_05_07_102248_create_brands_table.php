<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('brands')->insert([
            [
                'name' => 'Vinamilk',
                'slug' => 'vinamilk',
                'description' => 'Sữa và thực phẩm dinh dưỡng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TH True Milk',
                'slug' => 'th-true-milk',
                'description' => 'Sữa tươi và đồ uống',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Milo',
                'slug' => 'milo',
                'description' => 'Thức uống cacao lúa mạch',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acecook',
                'slug' => 'acecook',
                'description' => 'Mì gói và thực phẩm ăn liền',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Masan',
                'slug' => 'masan',
                'description' => 'Gia vị, mì, nước mắm',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Unilever',
                'slug' => 'unilever',
                'description' => 'Dầu gội, xà phòng, tiêu dùng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'P&G',
                'slug' => 'pg',
                'description' => 'Hàng tiêu dùng cá nhân',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coca Cola',
                'slug' => 'coca-cola',
                'description' => 'Nước ngọt giải khát',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pepsi',
                'slug' => 'pepsi',
                'description' => 'Nước ngọt giải khát',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hảo Hảo',
                'slug' => 'hao-hao',
                'description' => 'Mì gói phổ biến',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};