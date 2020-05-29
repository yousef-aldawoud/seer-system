<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostValidationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_validation_messages', function (Blueprint $table) {
            $table->id();
            $table->string('post_id');
            $table->string('user_id');
            $table->enum("status",['rejected','accepted']);
            $table->string("message")->nullable();
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
        Schema::dropIfExists('post_validation_messages');
    }
}
