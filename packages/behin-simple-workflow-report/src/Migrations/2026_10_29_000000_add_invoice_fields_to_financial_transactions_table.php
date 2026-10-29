<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wf_entity_financial_transactions', function (Blueprint $table) {
            $table->tinyInteger('invoice_issued')->nullable()->after('official_office')->comment('فاکتور صادر شده؟');
            $table->tinyInteger('invoice_received')->nullable()->after('invoice_issued')->comment('فاکتور فروش دریافت شده؟');
            $table->string('invoice_type')->nullable()->after('invoice_received')->comment('نوع فاکتور: رسمی/غیررسمی');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wf_entity_financial_transactions', function (Blueprint $table) {
            $table->dropColumn(['invoice_issued', 'invoice_received', 'invoice_type']);
        });
    }
};