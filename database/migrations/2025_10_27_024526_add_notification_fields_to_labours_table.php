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
            // CID Fields
            if (!Schema::hasColumn('labours', 'labour_cid_number')) {
                $table->string('labour_cid_number')->nullable()->after('labour_email');
            }
            if (!Schema::hasColumn('labours', 'labour_cid_issue_date')) {
                $table->date('labour_cid_issue_date')->nullable()->after('labour_cid_number');
            }
            if (!Schema::hasColumn('labours', 'labour_cid_expiry_date')) {
                $table->date('labour_cid_expiry_date')->nullable()->after('labour_cid_issue_date');
            }
            
            // Affidavit Fields
            if (!Schema::hasColumn('labours', 'labour_affidavit_number')) {
                $table->string('labour_affidavit_number')->nullable()->after('labour_cid_expiry_date');
            }
            if (!Schema::hasColumn('labours', 'labour_affidavit_issue_date')) {
                $table->date('labour_affidavit_issue_date')->nullable()->after('labour_affidavit_number');
            }
            if (!Schema::hasColumn('labours', 'labour_affidavit_expiry_date')) {
                $table->date('labour_affidavit_expiry_date')->nullable()->after('labour_affidavit_issue_date');
            }
            
            // Visa Fields
            if (!Schema::hasColumn('labours', 'labour_visa_status')) {
                $table->string('labour_visa_status')->nullable()->after('labour_affidavit_expiry_date');
            }
            if (!Schema::hasColumn('labours', 'labour_visa_submission_date')) {
                $table->date('labour_visa_submission_date')->nullable()->after('labour_visa_status');
            }
            if (!Schema::hasColumn('labours', 'labour_visa_approval_date')) {
                $table->date('labour_visa_approval_date')->nullable()->after('labour_visa_submission_date');
            }
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            // Drop CID Fields
            if (Schema::hasColumn('labours', 'labour_cid_number')) {
                $table->dropColumn('labour_cid_number');
            }
            if (Schema::hasColumn('labours', 'labour_cid_issue_date')) {
                $table->dropColumn('labour_cid_issue_date');
            }
            if (Schema::hasColumn('labours', 'labour_cid_expiry_date')) {
                $table->dropColumn('labour_cid_expiry_date');
            }
            
            // Drop Affidavit Fields
            if (Schema::hasColumn('labours', 'labour_affidavit_number')) {
                $table->dropColumn('labour_affidavit_number');
            }
            if (Schema::hasColumn('labours', 'labour_affidavit_issue_date')) {
                $table->dropColumn('labour_affidavit_issue_date');
            }
            if (Schema::hasColumn('labours', 'labour_affidavit_expiry_date')) {
                $table->dropColumn('labour_affidavit_expiry_date');
            }
            
            // Drop Visa Fields
            if (Schema::hasColumn('labours', 'labour_visa_status')) {
                $table->dropColumn('labour_visa_status');
            }
            if (Schema::hasColumn('labours', 'labour_visa_submission_date')) {
                $table->dropColumn('labour_visa_submission_date');
            }
            if (Schema::hasColumn('labours', 'labour_visa_approval_date')) {
                $table->dropColumn('labour_visa_approval_date');
            }
            

        });
    }
};
