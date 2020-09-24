<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardgames', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('negociation', 50);
            $table->string('price', 50)->nullable();
            $table->string('condition', 100);
            $table->string('edition', 150);
            $table->string('language', 50);
            $table->string('language_dependency', 50)->nullable();
            $table->longtext('description')->nullable();
            $table->string('owner', 50);
            $table->string('owner_contact', 100);
            $table->string('wishlist', 255)->nullable();
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
        Schema::dropIfExists('boardgames');
    }
}
