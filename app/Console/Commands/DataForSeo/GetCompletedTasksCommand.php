<?php

namespace App\Console\Commands\DataForSeo;

use Illuminate\Console\Command;
use App\Models\DataForSeo\Serp\Tasks;
use App\Models\DataForSeo\Serp\TaskResults;

class GetCompletedTasksCommand extends Command {
	
	const RESULT_INSERT_ITEMS_COUNT = 500;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dataforseo:srp_tasks_get';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get SERP Completed Tasks';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {
		$runtime_start = microtime(true);
		
		$srp_tasks = resolve('DFSService')->srp_tasks_get();
		if (empty($srp_tasks) || !is_array($srp_tasks)) {
			$this->info('Fail. Details in the log');
			return Command::FAILURE;
		}
		
		if (empty($srp_tasks['results']) || !is_array($srp_tasks['results'])) {
			$this->info('Result is empty');
			return Command::SUCCESS;
		}
		$srp_tasks = $srp_tasks['results'];
		
		foreach ($srp_tasks as $item) {
			if (empty($item['post_id'])) {
				$this->info('Post id not found');
				continue;
			}
			
			$task = Tasks::find($item['post_id']);
			if (empty($task)) {
				$this->info('Task for post_id=' . $item['post_id'] . ' not found');
				continue;
			}
			
			if ($task->is_processed) {
				$this->info('Task id=' . $task->id . ' has already been processed');
				continue;
			}
			
			$task_result = resolve('DFSService')->srp_tasks_get($item['task_id']);
			if (empty($task_result)) {
				$this->info('Fail for ' . $item['task_id'] . '. Details in the log');
				$task->processed();
				continue;
			}
			
			if (empty($task_result['results']['organic']) || !is_array($task_result['results']['organic'])) {
				$this->info('Result for ' . $item['task_id'] . ' is empty');
				$task->processed();
				continue;
			}
			
			$task_result['results']['organic'] = array_chunk($task_result['results']['organic'], self::RESULT_INSERT_ITEMS_COUNT);
			foreach($task_result['results']['organic'] as $result_group) {
				$task_results = [];
				
				foreach($result_group as $result_item) {
					$task_results[] = new TaskResults([
						'loc_id' => $result_item['loc_id'],
						'post_key' => $result_item['post_key'],
						'result_url' => $result_item['result_url'],
						'result_title' => $result_item['result_title'],
						'status' => $task_result['status'],
					]);
				}
				
				$task->results()->saveMany($task_results);
			}
			$task->processed();
			
		}

		$runtime_end = round(microtime(true) - $runtime_start, 4);

		$message = 'Success. Received ' . count($srp_tasks) . ' items';
		$message .= "\n";
		$message .= 'Execution time ' . $runtime_end . ' seconds';

		$this->info($message);

		return Command::SUCCESS;
	}

}
