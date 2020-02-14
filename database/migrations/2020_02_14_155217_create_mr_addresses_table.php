<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_addresses', function (Blueprint $table) {
          $table->Increments('id')->autoIncrement();
          $table->integer('CountryID');
          $table->string('City')->nullable();
          $table->string('Building')->nullable();
          $table->string('Address')->nullable();
          $table->string('Lat');
          $table->string('Lon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mr_addresses');
    }
}
