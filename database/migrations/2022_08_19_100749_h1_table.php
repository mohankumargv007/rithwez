<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class H1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h1_table', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('h1_name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('h2_table', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('h2_name');
            $table->integer('h1_id')->unsigned()->index('h1_id');
            $table->foreign('h1_id')
                           ->references('id')
                           ->on('h1_table')
                           ->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('h3_table', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('h3_name');
            $table->integer('h2_id')->unsigned()->index('h2_id');
            $table->foreign('h2_id')
                            ->references('id')
                            ->on('h2_table')
                            ->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('h4_table', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('h4_name');
            $table->integer('h3_id')->unsigned()->index('h3id');
            $table->foreign('h3_id')
                        ->references('id')
                        ->on('h3_table')
                        ->onDelete('cascade');
            $table->string('wall_type');            
            $table->string('roof_type');
            $table->string('no_of_stories');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('h1_table');
        Schema::dropIfExists('h2_table');
        Schema::dropIfExists('h3_table');
        Schema::dropIfExists('h4_table');
    }
}
