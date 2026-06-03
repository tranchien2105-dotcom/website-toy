<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Thông tin cơ bản
            $table->string('title');
            $table->text('description')->nullable();

            // Ảnh + link
            $table->string('image_url');
            $table->string('link_url')->nullable();

            // Phân loại banner (home, popup, sidebar,...)
            $table->string('type')->default('home');

            // Thiết bị hiển thị: all / mobile / desktop
            $table->string('device')->default('all');

            // Trạng thái
            $table->tinyInteger('status')->default(1); // 1: active, 0: inactive

            // Thứ tự hiển thị
            $table->integer('position')->default(0);

            // Thời gian chạy banner (campaign)
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            // Tracking
            $table->integer('click_count')->default(0);

            $table->timestamps();

            // Nếu muốn tối ưu query sau này
            $table->index(['status', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
}