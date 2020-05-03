<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reason');
			$table->bigInteger('item_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('approved')->default(0);
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('user_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
}
