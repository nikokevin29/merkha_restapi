<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('order');
            $table->foreignId('id_product')->constrained('product');
            $table->integer('amount');
            $table->decimal('subtotal');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('order_detail');
        Schema::enableForeignKeyConstraints();
    }
}
