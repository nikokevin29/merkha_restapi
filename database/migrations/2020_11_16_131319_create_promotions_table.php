<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->constrained('merchant');
            $table->foreignId('id_product')->constrained('product');
            $table->longText('promo_content');
            $table->decimal('promo_amount');
            $table->integer('active_status')->default(0);
            $table->string('photo')->nullable();
            $table->datetime('start_time');
            $table->datetime('end_time');
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
        Schema::dropIfExists('promotion');
        Schema::enableForeignKeyConstraints();
    }
}
