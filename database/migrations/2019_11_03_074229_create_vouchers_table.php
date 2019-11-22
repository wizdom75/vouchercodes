<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('promo_id')->index()->nullable();
            $table->string('retailer_mid')->index();
            $table->string('category_slug')->index();
            $table->string('type')->default('deal')->index();
            $table->enum('is_featured',[0,1])->index()->default(0);
            $table->enum('is_exclusive',[0,1])->index()->default(0); 
            $table->string('code')->nullable();
            $table->string('title');
            $table->text('blurb')->nullable();
            $table->text('terms')->nullable();
            $table->text('url')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
             
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
        Schema::dropIfExists('vouchers');
    }
}
