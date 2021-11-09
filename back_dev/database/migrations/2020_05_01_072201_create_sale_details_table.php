<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_id')->unsigned();
            $table->bigInteger('authorization_code_designation_id')->unsigned()->nullable();
            $table->bigInteger('price_type')->default(1); // 1 is regular, 2 is custom, 3 is other price category
            $table->bigInteger('location_starting_inventory_id')->unsigned();
            $table->bigInteger('product_location_id')->unsigned();
            $table->bigInteger('product_unit_id')->unsigned();
            $table->decimal('qty',20,2);
            $table->decimal('base_unit_qty',20,2);
            $table->decimal('price',20,2);
            $table->decimal('total',20,2);
            $table->tinyInteger('is_returned')->default(0);
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
        Schema::dropIfExists('sale_details');
    }
}
