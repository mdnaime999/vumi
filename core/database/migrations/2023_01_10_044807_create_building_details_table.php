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
        Schema::create('building_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('establisment_id')->unsigned()->nullable();
            $table->text('details')->nullable();
            $table->text('number')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>active, 0=>inactive');
            $table->timestamps();
            $table->foreign('establisment_id')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_details');
    }
};
