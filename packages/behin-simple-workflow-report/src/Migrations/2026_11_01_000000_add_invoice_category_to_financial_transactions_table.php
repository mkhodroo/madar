<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = 'wf_entity_financial_transactions';
        if (!Schema::hasTable($tableName)) {
            return;
        }

        $columns = [];
        if (!Schema::hasColumn($tableName, 'invoice_issued')) $columns[] = 'invoice_issued';
        if (!Schema::hasColumn($tableName, 'invoice_received')) $columns[] = 'invoice_received';
        if (!Schema::hasColumn($tableName, 'invoice_type')) $columns[] = 'invoice_type';
        if (!Schema::hasColumn($tableName, 'invoice_category')) $columns[] = 'invoice_category';

        if ($columns) {
            Schema::table($tableName, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    if (in_array($column, ['invoice_issued', 'invoice_received'], true)) {
                        $table->tinyInteger($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                }
            });
        }
    }

    public function down(): void
    {
        $tableName = 'wf_entity_financial_transactions';
        $columns = ['invoice_issued', 'invoice_received', 'invoice_type', 'invoice_category'];
        if (!Schema::hasTable($tableName)) return;

        $existing = array_filter($columns, fn ($column) => Schema::hasColumn($tableName, $column));
        if ($existing) Schema::table($tableName, fn (Blueprint $table) => $table->dropColumn($existing));
    }
};
