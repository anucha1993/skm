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
            // CID Financial Fields
            
            // เงินประกัน (Deposit)
            if (!Schema::hasColumn('labours', 'labour_cid_deposit_date')) {
                $table->date('labour_cid_deposit_date')->nullable()->comment('วันที่วางเงินประกัน')->after('labour_visa_approval_date');
            }
            
            if (!Schema::hasColumn('labours', 'labour_cid_deposit_total')) {
                $table->decimal('labour_cid_deposit_total', 10, 2)->nullable()->comment('จำนวนเงินวางประกัน')->after('labour_cid_deposit_date');
            }
            
            // CID-P (CID Payment)
            if (!Schema::hasColumn('labours', 'labour_cidp_date')) {
                $table->date('labour_cidp_date')->nullable()->comment('วันที่จ่าย CID-P')->after('labour_cid_deposit_total');
            }
            
            if (!Schema::hasColumn('labours', 'labour_cidp_total')) {
                $table->string('labour_cidp_total')->nullable()->comment('CID-P Total (V1/V2)')->after('labour_cidp_date');
            }
            
            if (!Schema::hasColumn('labours', 'labour_cidp_in_date')) {
                $table->date('labour_cidp_in_date')->nullable()->comment('วันที่รับ CID-P')->after('labour_cidp_total');
            }
            
            if (!Schema::hasColumn('labours', 'labour_cidp_in_total')) {
                $table->string('labour_cidp_in_total')->nullable()->comment('จำนวนเงินรับ CID-P (V1/V2)')->after('labour_cidp_in_date');
            }
            
            // ประเภทการชำระเงิน
            if (!Schema::hasColumn('labours', 'payment_type')) {
                $table->enum('payment_type', ['เงินสด', 'SCB', 'BBL'])->nullable()->comment('ประเภทการชำระเงิน')->after('labour_cidp_in_total');
            }
            
            // การคืนเงินประกัน
            if (!Schema::hasColumn('labours', 'labour_cid_deposit_status')) {
                $table->enum('labour_cid_deposit_status', ['None', 'ยกเลิก-คืนเงินประกัน', 'ยกเลิก-ไม่คืนเงินประกัน'])->default('None')->comment('สถานะการคืนเงินประกัน')->after('payment_type');
            }
            
            if (!Schema::hasColumn('labours', 'labour_refund_deposit_date')) {
                $table->date('labour_refund_deposit_date')->nullable()->comment('วันที่คืนเงินประกัน')->after('labour_cid_deposit_status');
            }
            
            if (!Schema::hasColumn('labours', 'labour_refund_deposit_total')) {
                $table->decimal('labour_refund_deposit_total', 10, 2)->nullable()->comment('จำนวนเงินคืน')->after('labour_refund_deposit_date');
            }
            
            // วันที่ยื่น CID (สำหรับระบบแจ้งเตือน)
            if (!Schema::hasColumn('labours', 'labour_cid_stand_date')) {
                $table->date('labour_cid_stand_date')->nullable()->comment('วันที่ยื่น CID')->after('labour_refund_deposit_total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labours', function (Blueprint $table) {
            $columns = [
                'labour_cid_deposit_date',
                'labour_cid_deposit_total', 
                'labour_cidp_date',
                'labour_cidp_total',
                'labour_cidp_in_date',
                'labour_cidp_in_total',
                'payment_type',
                'labour_cid_deposit_status',
                'labour_refund_deposit_date',
                'labour_refund_deposit_total',
                'labour_cid_stand_date'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('labours', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
