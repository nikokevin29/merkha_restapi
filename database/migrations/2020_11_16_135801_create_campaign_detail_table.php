<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('campaign_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_campaign')->constrained('campaign');
            $table->foreignId('id_merchant')->constrained('merchant');
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
        Schema::dropIfExists('campaign_detail');
        Schema::enableForeignKeyConstraints();
    }
}
