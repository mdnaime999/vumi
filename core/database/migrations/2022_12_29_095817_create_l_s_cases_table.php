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
        Schema::create('l_s_cases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('port_id')->unsigned();
            $table->string('project_name')->nullable();
            $table->string('number')->nullable();
            $table->date('possession_date')->nullable();
            $table->date('gazette_date')->nullable();
            $table->string('namjari_case_id')->nullable();
            $table->string('total_land')->nullable();
            $table->string('land_owner')->nullable();
            $table->string('land_price')->nullable();
            $table->string('kotian_no')->nullable();
            $table->string('jote_no')->nullable();
            $table->string('district')->nullable();
            $table->string('upzilla')->nullable();
            $table->string('moja')->nullable();
            $table->string('pdf')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>active, 0=>inactive');
            $table->timestamps();
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_s_cases');
    }
};
