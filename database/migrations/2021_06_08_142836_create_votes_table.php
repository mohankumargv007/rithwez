<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
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
            $table->integer('vote_category')->comment('0 - question, 1 - answer, 2 - comment');
            $table->integer('vote_type')->comment('1 - upvote, 0 - downvote');
            $table->integer('status')->comment('0 => deleted, 1 => active');
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
        Schema::dropIfExists('votes');
    }
}
