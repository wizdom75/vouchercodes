<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSomeColums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->registerEnumWithDoctrine();
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('category_slug');
        });
        Schema::table('vouchers', function (Blueprint $table) {
            $table->text('category_slug')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->registerEnumWithDoctrine();
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('category_slug');
            $table->text('category_slug')->change();
        });
    }

    private function registerEnumWithDoctrine()
    {
        DB::getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }
}
