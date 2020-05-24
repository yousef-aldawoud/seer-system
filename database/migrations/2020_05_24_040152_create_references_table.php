<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("author")->nullable();
            $table->string("link")->nullable();
            $table->enum("type",['book','link']);
            $table->enum("status",["validation","accepted"])->default("validation");
            $table->json("details")->nullable();
            $table->timestamps();
        });
        
        Schema::create('post_reference', function (Blueprint $table) {
            $table->id();
            $table->string("post_id");
            $table->string("reference_id");
            $table->string("description")->nullable();
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
        Schema::dropIfExists('references');
        Schema::dropIfExists('post_reference');
    }
}
