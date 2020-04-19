<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantIdColumnToClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('clicks');
        Schema::create('clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('merchant_id')->nullable();
            $table->integer('voucher_id')->nullable();
            $table->integer('user_id')->default(0);
            $table->string('ip')->nullable();
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
        Schema::table('clicks', function (Blueprint $table) {
            //
        });
    }
}
