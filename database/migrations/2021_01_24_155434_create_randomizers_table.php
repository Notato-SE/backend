<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRandomizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('randomizers', function (Blueprint $table) {
            $table->id();
            $table->json('inputs');
            $table->json('results');
            $table->string("name");
            // $table->unsignedInteger('user_id');

            // $table->unsignedInteger('random_type');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedSmallInteger('random_type');

            $table->timestamps();

            $table->index("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('randomizers');
    }
}
