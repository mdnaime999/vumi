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
        Schema::create('tofsils', function (Blueprint $table) {
            $table->id();
            $table->string('kotian_no')->nullable();
            $table->string('dag_no')->nullable();
            $table->bigInteger('classified_type_id')->unsigned()->nullable();
            $table->bigInteger('land_type_id')->unsigned()->nullable();
            $table->bigInteger('l_s_case_id')->unsigned()->nullable();
            $table->string('total_land')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>active, 0=>inactive');
            $table->timestamps();
            $table->foreign('classified_type_id')->references('id')->on('classified_types')->onDelete('cascade');
            $table->foreign('land_type_id')->references('id')->on('land_types')->onDelete('cascade');
            $table->foreign('l_s_case_id')->references('id')->on('l_s_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tofsils');
    }
};
