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
            $table->string('merchant_logo')->nullable();
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('unit')->nullable();
            $table->string('timezone')->nullable();
            $table->string('longlat')->nullable();
            
            $table->string('mall')->nullable();
            $table->string('building_name')->nullable();
            $table->string('floor')->nullable();
            $table->string('other_notes')->nullable();
            
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
