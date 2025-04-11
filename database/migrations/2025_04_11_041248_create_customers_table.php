<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // ชื่อลูกค้า
            $table->string('country');             // ประเทศ (สำหรับ Select)
            $table->enum('status', ['disabled', 'active'])->default('active'); // สถานะ
            $table->text('notes')->nullable();     // บันทึกเพิ่มเติม
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
