<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serp_task_results', function (Blueprint $table) {
             $table->id();
			
			$table->unsignedBigInteger('task_id');
			$table->unsignedBigInteger('loc_id');
            $table->text('post_key');
			$table->text('result_url');
			$table->text('result_title');
			$table->enum('status', ['ok', 'error']);
			
			$table->foreign('task_id', 'fk_task_results_task_id_to_tasks_id')
				->references('id')->on('serp_tasks')
				->onUpdate('cascade')
				->onDelete('cascade');
			
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
        Schema::dropIfExists('task_results');
    }
}
