<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('wf_entity_borrow_requests')) {
            return;
        }

        Schema::table('wf_entity_borrow_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('wf_entity_borrow_requests', 'not_available_at')) {
                $table->string('not_available_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('wf_entity_borrow_requests', 'not_available_at_alt')) {
                $table->unsignedBigInteger('not_available_at_alt')->nullable()->after('not_available_at');
            }
            if (!Schema::hasColumn('wf_entity_borrow_requests', 'not_available_by')) {
                $table->unsignedBigInteger('not_available_by')->nullable()->after('not_available_at_alt');
            }
            if (!Schema::hasColumn('wf_entity_borrow_requests', 'not_available_note')) {
                $table->text('not_available_note')->nullable()->after('not_available_by');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('wf_entity_borrow_requests')) {
            return;
        }

        Schema::table('wf_entity_borrow_requests', function (Blueprint $table) {
            $columns = array_filter([
                'not_available_note',
                'not_available_by',
                'not_available_at_alt',
                'not_available_at',
            ], fn($column) => Schema::hasColumn('wf_entity_borrow_requests', $column));

            if (!empty($columns)) {
                $table->dropColumn(array_values($columns));
            }
        });
    }
};