<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('instant_users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->integer('user_task_id');

            $table->unsignedBigInteger('content_id');
            $table->foreign('content_id')->references('id')->on('task_contents')
                    ->cascadeOnDelete()->cascadeOnUpdate();

            $table->boolean('archived')->default(false);
            $table->dateTime('limits');

            $table->foreignId('evaluation_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            
            $table->timestamps();

            $table->softDeletes();
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
