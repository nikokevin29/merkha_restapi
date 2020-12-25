<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->nullable()->constrained('merchant');
            $table->foreignId('id_employee')->nullable()->constrained('employee');
            $table->string('voucher_name');
            $table->string('voucher_code');
            $table->string('voucher_type');
            $table->decimal('disc_amount')->default(0);
            $table->float('disc_rate')->default(0);
            $table->date('valid_date');
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
        Schema::dropIfExists('voucher');
        Schema::enableForeignKeyConstraints();
    }
}
