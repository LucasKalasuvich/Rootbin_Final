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
        Schema::create('case_insident_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('case_insidents');
            $table->foreignId('status_id')->constrained('case_statuses');
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
        Schema::dropIfExists('case_insident_statuses');
    }
};
