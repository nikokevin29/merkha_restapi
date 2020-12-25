<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->constrained('merchant');
            $table->foreignId('id_category')->constrained('product_category');
            $table->string('product_name');
            $table->longText('description')->nullable();
            $table->decimal('price');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->integer('stock');
            $table->float('weight');
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
        Schema::dropIfExists('product');
        Schema::enableForeignKeyConstraints();
    }
}
