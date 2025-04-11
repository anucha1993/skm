<?php
// database/migrations/2023_01_01_000000_create_global_sets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('global_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // ชื่อชุด
            $table->text('description')->nullable();      // รายละเอียด
            $table->enum('sort_order_preference', ['entered', 'alphabetical'])
                  ->default('entered');                   // ค่าเรียงลำดับค่าในชุด
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_sets');
    }
};
