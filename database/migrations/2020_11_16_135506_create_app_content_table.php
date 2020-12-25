<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('app_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employee')->constrained('employee');
            $table->string('parent');
            $table->string('location');
            $table->string('position');
            $table->string('url_image');
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
        Schema::dropIfExists('app_content');
        Schema::enableForeignKeyConstraints();
    }
}