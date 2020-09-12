<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookStorageRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_storage_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('available_capacity');
            $table->double('price');
            $table->boolean('is_confirmed')->default(false);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('storage_id')->unsigned()->index();
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
        Schema::dropIfExists('book_storage_requests');
    }
}
