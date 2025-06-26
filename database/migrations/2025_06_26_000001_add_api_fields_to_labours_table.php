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
            // เพิ่มฟิลด์ใหม่หากไม่มี
            if (!Schema::hasColumn('labours', 'labour_note')) {
                $table->text('labour_note')->nullable()->after('labour_status');
            }
            
            if (!Schema::hasColumn('labours', 'api_imported_at')) {
                $table->timestamp('api_imported_at')->nullable()->after('labour_note');
            }
            
            if (!Schema::hasColumn('labours', 'api_candidate_id')) {
                $table->string('api_candidate_id')->nullable()->after('api_imported_at');
            }
            
            // เพิ่มฟิลด์ที่อยู่
            if (!Schema::hasColumn('labours', 'labour_address')) {
                $table->text('labour_address')->nullable()->after('api_candidate_id');
            }
            
            if (!Schema::hasColumn('labours', 'labour_address_type')) {
                $table->string('labour_address_type')->nullable()->after('labour_address');
            }
            
            if (!Schema::hasColumn('labours', 'labour_province')) {
                $table->string('labour_province')->nullable()->after('labour_address_type');
            }
            
            if (!Schema::hasColumn('labours', 'labour_district')) {
                $table->string('labour_district')->nullable()->after('labour_province');
            }
            
            if (!Schema::hasColumn('labours', 'labour_sub_district')) {
                $table->string('labour_sub_district')->nullable()->after('labour_district');
            }
            
            if (!Schema::hasColumn('labours', 'labour_postcode')) {
                $table->string('labour_postcode', 10)->nullable()->after('labour_sub_district');
            }
            
            if (!Schema::hasColumn('labours', 'labour_emergency_contact_name')) {
                $table->string('labour_emergency_contact_name')->nullable()->after('labour_postcode');
            }
            
            if (!Schema::hasColumn('labours', 'labour_line_id')) {
                $table->string('labour_line_id')->nullable()->after('labour_emergency_contact_name');
            }
            
            if (!Schema::hasColumn('labours', 'labour_email')) {
                $table->string('labour_email')->nullable()->after('labour_line_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            if (Schema::hasColumn('labours', 'labour_note')) {
                $table->dropColumn('labour_note');
            }
            
            if (Schema::hasColumn('labours', 'api_imported_at')) {
                $table->dropColumn('api_imported_at');
            }
            
            if (Schema::hasColumn('labours', 'api_candidate_id')) {
                $table->dropColumn('api_candidate_id');
            }
            
            // ลบฟิลด์ที่อยู่
            if (Schema::hasColumn('labours', 'labour_address')) {
                $table->dropColumn('labour_address');
            }
            
            if (Schema::hasColumn('labours', 'labour_address_type')) {
                $table->dropColumn('labour_address_type');
            }
            
            if (Schema::hasColumn('labours', 'labour_province')) {
                $table->dropColumn('labour_province');
            }
            
            if (Schema::hasColumn('labours', 'labour_district')) {
                $table->dropColumn('labour_district');
            }
            
            if (Schema::hasColumn('labours', 'labour_sub_district')) {
                $table->dropColumn('labour_sub_district');
            }
            
            if (Schema::hasColumn('labours', 'labour_postcode')) {
                $table->dropColumn('labour_postcode');
            }
            
            if (Schema::hasColumn('labours', 'labour_emergency_contact_name')) {
                $table->dropColumn('labour_emergency_contact_name');
            }
            
            if (Schema::hasColumn('labours', 'labour_line_id')) {
                $table->dropColumn('labour_line_id');
            }
            
            if (Schema::hasColumn('labours', 'labour_email')) {
                $table->dropColumn('labour_email');
            }
        });
    }
};
