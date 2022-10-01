<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('name');
            $table->integer('state_id');
            $table->string('state_code');
            $table->integer('country_id');
            $table->string('country_code');
            $table->decimal('latitude',10,8);
            $table->decimal('longitude',11,8);
            $table->boolean('flag')->default(1);            
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
        Schema::dropIfExists('cities');
    }
}
