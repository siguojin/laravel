<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyArtivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_artivity', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name",20)->default("")->comment("活动名称");
            $table->string("activity_config")->default("")->comment("活动配置");
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
        Schema::dropIfExists('jy_artivity');
    }
}
