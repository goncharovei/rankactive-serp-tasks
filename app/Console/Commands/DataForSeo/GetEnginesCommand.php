<?php

namespace App\Console\Commands\DataForSeo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetEnginesCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dataforseo:cmn_se';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get list of Search Engines';

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
		$items = resolve('DFSService')->cmn_se();
		if (empty($items) || !is_array($items)) {
			$this->info('Fail. Details in the log');
			return Command::FAILURE;
		}

		for ($i = 0; $i < count($items); $i++) {
			if (empty($items[$i]['se_id'])) {
				$this->info('Fail. Variable "se_id" not found');
				return Command::FAILURE;
			}
			
			$items[$items[$i]['se_id']] = $items[$i];
			unset($items[$i]);
		}
		//todo: to "hash"
		Redis::set('dataforseo.search_engines', json_encode($items));
		
		$this->info('Success. Received ' . count($items) . ' items');

		return Command::SUCCESS;
	}

}
