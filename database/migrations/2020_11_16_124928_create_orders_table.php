<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->constrained('merchant');
            $table->foreignId('id_buyer')->constrained('user');
            $table->foreignId('id_destination')->constrained('address');
            $table->foreignId('id_voucher')->nullable()->constrained('voucher');
            $table->foreignId('id_campaign')->nullable()->constrained('campaign');
            $table->date('received_date');
            $table->string('order_status')->nullable();
            $table->decimal('shipping_price');
            $table->decimal('discount_price')->default(0);
            $table->decimal('total_price');
            $table->timestamps();
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
        Schema::dropIfExists('order');
        Schema::enableForeignKeyConstraints();
    }
}
