<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('feed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('user');
            $table->foreignId('id_merchant')->nullable()->constrained('merchant');
            $table->foreignId('id_product')->constrained('product');
            $table->integer('like_count')->default(0);
            $table->string('url_image');
            $table->longText('caption');
            $table->string('location')->nullable();
            $table->integer('report_count')->default(0);
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
        Schema::dropIfExists('feed');
        Schema::enableForeignKeyConstraints();
    }
}
