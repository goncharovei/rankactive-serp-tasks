<?php

namespace App\Console\Commands\DataForSeo;

use Illuminate\Console\Command;

class GetCompletedTasksCommand extends Command {

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
		//todo
		return Command::SUCCESS;
	}
	
	
}
