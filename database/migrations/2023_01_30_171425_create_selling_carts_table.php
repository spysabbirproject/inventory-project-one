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
        Schema::create('selling_carts', function (Blueprint $table) {
            $table->id();
            $table->string('selling_invoice_no');
            $table->date('selling_date');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->integer('selling_quantity')->nullable();
            $table->float('selling_price')->nullable();;
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
        Schema::dropIfExists('selling_carts');
    }
};
