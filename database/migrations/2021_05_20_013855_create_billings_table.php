<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_id')->unsigned();
            $table->float('base_fare');
            $table->float('weighted_cost');
            $table->float('origin_cost');
            $table->float('calculated_sum');
            $table->float('tax_per')->default('10');
            $table->float('total_pay');
            $table->string('ref')->nullable();
            $table->smallInteger('status');

            $table->foreign('shipping_id')->references('id')->on('shipping_details')->cascadeOnDelete();
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
        Schema::dropIfExists('billings');
    }
}
