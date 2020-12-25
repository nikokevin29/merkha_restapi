<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('merchant_bank', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->constrained('merchant');
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->string('holders_name');
            $table->string('letter_of_authorization')->nullable();
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
        Schema::dropIfExists('merchant_bank');
        Schema::enableForeignKeyConstraints();
    }
}
