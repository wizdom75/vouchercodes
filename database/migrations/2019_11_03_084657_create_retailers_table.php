<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailers', function (Blueprint $table) {
            $table->string('mid')->unique();
            $table->string('slug')->unique();
            $table->integer('category_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('title');
            $table->string('meta')->nullable();
            $table->text('description')->nullable(); 
            $table->string('logo')->nullable(); 
            $table->string('url')->nullable();
            $table->string('tracking_url')->nullable();
            $table->enum('is_featured',[0,1])->index()->default(0);    
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
        Schema::dropIfExists('retailers');
    }
}
