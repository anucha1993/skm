<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            $table->float('weight')->nullable()->after('labour_email');
            $table->float('height')->nullable()->after('weight');
            $table->float('bmi')->nullable()->after('height');
        });
    }

    public function down(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            $table->dropColumn(['weight', 'height', 'bmi']);
        });
    }
};
