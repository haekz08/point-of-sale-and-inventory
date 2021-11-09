<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_purchase_id')->unsigned();
            $table->bigInteger('product_unit_id')->unsigned();
            $table->bigInteger('location_starting_inventory_id')->unsigned();
            $table->bigInteger('product_location_id')->unsigned();
            $table->decimal('base_unit_qty',20,2);
            $table->decimal('qty',20,2);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('product_purchase_details');
    }
}
