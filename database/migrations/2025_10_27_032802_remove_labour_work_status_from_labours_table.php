<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            if (Schema::hasColumn('labours', 'labour_work_status')) {
                $table->dropColumn('labour_work_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            if (!Schema::hasColumn('labours', 'labour_work_status')) {
                $table->string('labour_work_status')->nullable()->default('รอดำเนินการ');
            }
        });
    }
};
