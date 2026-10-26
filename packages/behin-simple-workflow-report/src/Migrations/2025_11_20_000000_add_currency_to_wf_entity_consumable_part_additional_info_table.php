<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wf_entity_consumable_part_additional_info', function (Blueprint $table) {
            if (!Schema::hasColumn('wf_entity_consumable_part_additional_info', 'currency')) {
                $table->string('currency')->nullable()->after('unit_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wf_entity_consumable_part_additional_info', function (Blueprint $table) {
            if (Schema::hasColumn('wf_entity_consumable_part_additional_info', 'currency')) {
                $table->dropColumn('currency');
            }
        });
    }
};
