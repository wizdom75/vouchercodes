<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailerBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('retailer_mid')->unique();
            $table->string('banner')->nullable(); 
            $table->timestamps();

            $table->foreign('retailer_mid')
                ->references('mid')
                ->on('retailers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailer_banners');
    }
}
