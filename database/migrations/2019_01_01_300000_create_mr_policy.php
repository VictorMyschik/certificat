<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createmrpolicy extends Migration
{
    public function up()
    {
        Schema::create('mr_policy', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('LanguageID')->unique();
            $table->text('Text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mr_policy');
    }
}
