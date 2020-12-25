<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('user');
            $table->string('address_save_name');
            $table->longText('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('province');
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
        Schema::dropIfExists('address');
        Schema::enableForeignKeyConstraints();
    }
}
