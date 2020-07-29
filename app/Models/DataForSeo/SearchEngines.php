<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

class SearchEngines {

	public static function clear() {
		$item_keys = Redis::hGetAll('dataforseo:search_engines_map_sorted');
		Redis::unlink($item_keys);
		Redis::unlink('dataforseo:search_engines_map_sorted');
	}
	
	public static function add(array $item) {
		if (empty($item)) {
			return;
		}
		
		$item_key = 'dataforseo:search_engines:' . $item['se_id'];
		Redis::multi()
				->hMSet($item_key, $item)
				->rPush('dataforseo:search_engines_map_sorted', $item['se_id'])
				->exec();
	}
	
	public static function sort($a, $b) {
		if (empty($a['se_name']) || empty($b['se_name'])) {
			return 0;
		}

		return strcmp($a['se_name'], $b['se_name']);
	}
}
