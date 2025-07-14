<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('skill_tests', function (Blueprint $table) {
            $table->bigIncrements('skill_test_id'); // เปลี่ยน primary key เป็น skill_test_id
            $table->unsignedBigInteger('labour_id');
            $table->date('test_date');
            $table->unsignedBigInteger('test_location_id'); // global-sets id:2
            $table->unsignedBigInteger('test_position_id'); // global-sets id:5
            $table->unsignedBigInteger('test_result_id');   // global-sets id:10
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('labour_id')->references('labour_id')->on('labours')->onDelete('cascade'); // อ้างอิง labour_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('skill_tests');
    }
};
