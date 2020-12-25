<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_merchant')->nullable()->constrained('merchant');
            $table->foreignId('id_user')->nullable()->constrained('user');
            $table->foreignId('id_feed')->constrained('feed');
            $table->longText('comment');
            $table->string('mention')->nullable();
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
        Schema::dropIfExists('comment');
        Schema::enableForeignKeyConstraints();
    }
}
