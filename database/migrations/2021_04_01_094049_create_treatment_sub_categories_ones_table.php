<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentSubCategoriesOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_sub_categories_ones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('treatment_id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('showDropDown');
            $table->timestamps();
        });
        Schema::table('treatment_sub_categories_ones', function ($table) {
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatment_sub_categories_ones');
    }
}
