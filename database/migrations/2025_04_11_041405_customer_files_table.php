<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // เชื่อมโยงกับลูกค้า
            $table->string('file_path');            // ที่อยู่ไฟล์ที่เก็บไว้
            $table->string('file_original_name');   // ชื่อไฟล์ต้นฉบับ
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_files');
    }
};
