<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('question_id')->unsigned()->index('question_id');
            $table->foreign('question_id')
                           ->references('id')
                           ->on('questions')
                           ->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->foreign('user_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('cascade');
            $table->integer('edited_by')->nullable();
            $table->string('created_by');
            $table->integer('status')->comment('0 => deleted, 1 => active');     
            $table->boolean('accepted')->default(false);       
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
        Schema::dropIfExists('answers');
    }
}
