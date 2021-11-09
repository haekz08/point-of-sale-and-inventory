<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('transaction_date');
            $table->string('order_number')->nullable();
            $table->string('charged_number')->nullable();
            $table->decimal('sub_total',20,2);
            $table->decimal('discount',20,2);
            $table->decimal('grand_total',20,2);
            $table->decimal('vatable',20,2);
            $table->decimal('vat',20,2);
            $table->string('check_number')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('payment_mode_id')->unsigned();
            $table->bigInteger('sales_rep_id')->unsigned()->comment('staff_id');
            $table->bigInteger('cashier_id')->unsigned()->comment('staff_id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->tinyInteger('is_payment')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
