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
        Schema::create('serp_tasks', function (Blueprint $table) {
            $table->id();
			
			$table->unsignedBigInteger('se_id');
			$table->unsignedBigInteger('loc_id');
            $table->text('key');
			$table->unsignedBigInteger('task_id')->nullable();
			$table->boolean('status')->default(0);
			
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
        Schema::dropIfExists('serp_tasks');
    }
}
