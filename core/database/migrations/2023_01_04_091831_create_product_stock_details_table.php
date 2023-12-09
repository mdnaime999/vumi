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
        Schema::create('product_stock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_stock_id')->unsigned();
            $table->foreign('product_stock_id')->references('id')->on('product_stocks')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('product_id')->nullable();
            $table->string('stock')->default(0)->nullable();
            $table->tinyInteger('type')->nullable()->comment('1=প্যাঃ, 2=বক্স, 3=রোল, 4=বোতল, 5=সংখ্যা');
            $table->string('price', 50)->nullable();
            $table->date('date')->nullable();
            $table->date('warranty_date')->nullable();
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
        Schema::dropIfExists('product_stock_details');
    }
};
