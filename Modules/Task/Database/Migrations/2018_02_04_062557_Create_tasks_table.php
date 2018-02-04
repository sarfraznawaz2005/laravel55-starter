<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->text('description');
            $table->string('file')->nullable();
            $table->boolean('completed')->default(false);

            $table->unsignedInteger('created_by')->default(0);
            $table->unsignedInteger('updated_by')->default(0);

            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
