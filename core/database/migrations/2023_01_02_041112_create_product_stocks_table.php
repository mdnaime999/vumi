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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('port_id')->nullable();
            $table->tinyInteger('tender_type')->default(1)->comment('1=open_tender, 2=direct_tender');
            $table->string('tender_number', 100)->nullable();
            $table->tinyInteger('asset_type')->default(1)->comment('1=office_equipment, 2=stationary');
            $table->string('total_price', 50)->nullable();
            $table->date('all_date')->nullable();
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
        Schema::dropIfExists('product_stocks');
    }
};
