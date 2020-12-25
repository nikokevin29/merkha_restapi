<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employee')->constrained('employee');
            $table->string('campaign_code_name');
            $table->decimal('campaign_amount')->nullable();
            $table->float('campaign_rate')->nullable();
            $table->string('campaign_type');
            $table->integer('max_usage_per_user');
            $table->integer('min_basket_size');
            $table->integer('max_redemption');
            $table->float('promo_fund_split');
            $table->string('campaign_status');
            $table->datetime('start_date');
            $table->datetime('end_date');
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
        Schema::dropIfExists('campaign');
        Schema::enableForeignKeyConstraints();
    }
}
