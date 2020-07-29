<?php

namespace App\Console\Commands\DataForSeo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetLocationsCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dataforseo:cmn_locations';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get list of Locations';

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
		
		$items = resolve('DFSService')->cmn_locations();
		if (empty($items) || !is_array($items)) {
			$this->info('Fail. Details in the log');
			return Command::FAILURE;
		}

		$item_keys = Redis::hGetAll('dataforseo:locations_map_sorted');
		Redis::unlink($item_keys);
		Redis::unlink('dataforseo:locations_map_sorted');

		usort($items, function($a, $b) {
			if (empty($a['loc_name']) || empty($b['loc_name'])) {
				return 0;
			}

			return strcmp($a['loc_name'], $b['loc_name']);
		});

		$engine_index = 0;
		foreach ($items as $item) {
			if (empty($item['loc_id'])) {
				continue;
			}
			
			$item_key = 'dataforseo:locations:' . $item['loc_id'];
			Redis::multi()
					->hMSet($item_key, $item)
					->hSet('dataforseo:locations_map_sorted', $engine_index++, $item_key)
					->exec();
		}

		$runtime_end = round(microtime(true) - $runtime_start, 4);

		$message = 'Success. Received ' . count($items) . ' items';
		$message .= "\n";
		$message .= 'Execution time ' . $runtime_end . ' seconds';

		$this->info($message);
		
		return Command::SUCCESS;
	}
	
	
}
