<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionTaskContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_task_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_content_id')->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('reaction_id')->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('reaction_task_content');
    }
}