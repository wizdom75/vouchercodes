<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('feed_id')->index();
            $table->integer('retailer_mid_col')->nullable();
            $table->integer('type_col')->nullable();;
            $table->integer('code_col')->nullable();
            $table->integer('title_col')->nullable();
            $table->integer('blurb_col')->nullable();
            $table->integer('terms_col')->nullable();
            $table->integer('url_col')->nullable();
            $table->integer('valid_from_col')->nullable();
            $table->integer('valid_to_col')->nullable();
            $table->integer('category_slug_col')->nullable();
            $table->integer('promo_col')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_settings');
    }
}
