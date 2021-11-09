<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_id')->unsigned();
            $table->bigInteger('credited_sale_id')->unsigned()->nullable()->comment('sale_id');
            $table->date('transaction_date');
            $table->decimal('total',20,2);
            $table->bigInteger('return_type_id')->unsigned();
            $table->bigInteger('sales_rep_id')->unsigned()->comment('staff_id');
            $table->bigInteger('cashier_id')->unsigned()->comment('staff_id');
            $table->tinyInteger('is_credited')->default(0);
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
        Schema::dropIfExists('sale_returns');
    }
}
