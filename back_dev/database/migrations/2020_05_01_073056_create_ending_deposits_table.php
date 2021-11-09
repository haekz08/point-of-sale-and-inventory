<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndingDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ending_deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('transaction_date');
            $table->bigInteger('staff_id')->unsigned();
            $table->decimal('total',20,2);
            $table->decimal('bdq_1',20,2)->comment('break down qty');
            $table->decimal('bdq_2',20,2)->comment('break down qty');
            $table->decimal('bdq_3',20,2)->comment('break down qty');
            $table->decimal('bdq_4',20,2)->comment('break down qty');
            $table->decimal('bdq_5',20,2)->comment('break down qty');
            $table->decimal('bdq_6',20,2)->comment('break down qty');
            $table->decimal('bdq_7',20,2)->comment('break down qty');
            $table->decimal('bdq_8',20,2)->comment('break down qty');
            $table->decimal('bdq_9',20,2)->comment('break down qty');
            $table->decimal('bdq_10',20,2)->comment('break down qty');
            $table->decimal('bdq_11',20,2)->comment('break down qty');
            $table->decimal('bdq_12',20,2)->comment('break down qty');
            $table->string('remarks');
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
        Schema::dropIfExists('ending_deposits');
    }
}
