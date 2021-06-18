<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('loan_type');
            $table->integer('interest_rate');
            $table->integer('loan_amount');
            $table->integer('emi_plan');
            $table->integer('weekly_pay');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->foreign('user_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('cascade');
            $table->enum('status',['In-Progress', 'Approved', 'Closed'])->default('In-Progress');
            $table->integer('approved_by')->nullable();
            $table->timestamps();
        });

        Schema::create('user_loan_emis', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('emi_week');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->foreign('user_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('cascade');
            $table->integer('loan_id')->unsigned()->index('loan_id');
            $table->foreign('loan_id')
                           ->references('id')
                           ->on('user_loans')
                           ->onDelete('cascade');
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
        Schema::dropIfExists('user_loans');
    }
}
