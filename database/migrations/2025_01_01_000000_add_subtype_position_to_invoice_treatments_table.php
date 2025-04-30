<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtypePositionToInvoiceTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_treatments', function (Blueprint $table) {
            if (!Schema::hasColumn('invoice_treatments', 'subtype_id')) {
                $table->unsignedBigInteger('subtype_id')->nullable()->after('treatMent');
            }

            if (!Schema::hasColumn('invoice_treatments', 'position_id')) {
                $table->unsignedBigInteger('position_id')->nullable()->after('subtype_id');
            }

            // Add foreign key constraints
            $table->foreign('subtype_id')->references('id')->on('treatment_sub_categories_ones')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('treatment_sub_categories_twos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_treatments', function (Blueprint $table) {
            $table->dropForeign(['subtype_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['subtype_id', 'position_id']);
        });
    }
}
