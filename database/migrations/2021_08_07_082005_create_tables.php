<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinds', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name')->comment('종류 이름');
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name')->comment('색깔 이름');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kind_id');
            $table->foreign('kind_id')->references('id')->on('kinds');

            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->enum('type', ['feed', 'grooming', 'review'])->default('feed')->comment('질문타입');
            $table->string('title')->comment('제목');
            $table->text('content')->comment('내용');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->text('content')->comment('내용');
            $table->enum('choose', ['Y', 'N'])->default('N');

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('kinds');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
    }
}
