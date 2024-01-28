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
        Schema::create('case_insidents', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('medrec_number');
            $table->date('reporting_date');
            $table->date('insident_date');
            $table->time('insident_time');
            $table->text('chronology')->nullable();
            $table->enum('status', ['WAITING', 'VERIFIED']);
            $table->text('additional_information')->nullable();
            // $table->text('riskman_number')->nullable();
            $table->string('reporter_name');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_insidents');
    }
};
