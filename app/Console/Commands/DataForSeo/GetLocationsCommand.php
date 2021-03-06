<?php

namespace App\Console\Commands\DataForSeo;

use Illuminate\Console\Command;
use App\Models\DataForSeo\Locations;

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
		
		if (empty($items['results']) || !is_array($items['results'])) {
			$this->info('Result is empty');
			return Command::SUCCESS;
		}
		$items = $items['results'];
		
		Locations::clear();
		
		usort($items, [Locations::class, 'sort']);
		foreach ($items as $item) {
			if (empty($item['loc_id'])) {
				continue;
			}
			
			Locations::add($item);
		}

		$runtime_end = round(microtime(true) - $runtime_start, 4);

		$message = 'Success. Received ' . count($items) . ' items';
		$message .= "\n";
		$message .= 'Execution time ' . $runtime_end . ' seconds';

		$this->info($message);
		
		return Command::SUCCESS;
	}
	
	
}
