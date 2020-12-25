<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('merchant_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->constrained('merchant');
            $table->string('ktp');
            $table->string('npwp');
            $table->string('statement_letter');
            $table->string('storefront_photo');
            $table->string('business_license');
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
        Schema::dropIfExists('merchant_file');
        Schema::enableForeignKeyConstraints();
    }
}
