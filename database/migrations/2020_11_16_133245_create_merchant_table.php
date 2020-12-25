<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('merchant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('user');
            $table->foreignId('id_business_type')->constrained('business_type');
            $table->foreignId('id_merchant_category')->constrained('merchant_category');
            $table->string('merchant_id');
            $table->string('name');
            $table->longText('address');
            $table->string('city');
            $table->string('email');
            $table->string('phone_number');
            $table->string('status');
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
        Schema::dropIfExists('merchant');
        Schema::enableForeignKeyConstraints();
    }
}
