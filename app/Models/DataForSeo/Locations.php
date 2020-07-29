<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

class Locations {

	public static function clear() {
		$item_keys = Redis::hGetAll('dataforseo:locations_map_sorted');
		Redis::unlink($item_keys);
		Redis::unlink('dataforseo:locations_map_sorted');
	}
	
	public static function add(array $item) {
		if (empty($item)) {
			return;
		}
		
		$item_key = 'dataforseo:locations:' . $item['loc_id'];
		Redis::multi()
				->hMSet($item_key, $item)
				->rPush('dataforseo:locations_map_sorted', $item['loc_id'])
				->exec();
	}
	
	public static function sort($a, $b) {
		if (empty($a['loc_name']) || empty($b['loc_name'])) {
			return 0;
		}

		return strcmp($a['loc_name'], $b['loc_name']);
	}
}
