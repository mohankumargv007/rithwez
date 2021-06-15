<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->foreign('user_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('cascade');
            $table->text('content')->nullable();
            $table->text('slug');
            $table->integer('views')->default(0);
            $table->integer('status')->comment('0 => deleted, 1 => active, 2 => duplicated');
            $table->integer('created_by');
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
        Schema::dropIfExists('questions');
    }
}
