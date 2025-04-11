<?php
// database/migrations/2023_01_01_000001_create_global_set_values_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('global_set_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('global_set_id')            // FK ไปยังตาราง global_sets
                  ->constrained()
                  ->onDelete('cascade');                  // ลบ Global Set หลักแล้วลบค่าด้วย
            $table->string('value');                      // ค่าที่อยู่ในชุด
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_set_values');
    }
};
