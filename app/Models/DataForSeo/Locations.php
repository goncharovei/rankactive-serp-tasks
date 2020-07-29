<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

class Locations extends CommonApiFactory {

	protected const REDIS_PARAM_NAME_MAP = parent::REDIS_PARAM_NAME_ROOT .
			parent::REDIS_PARAM_SEPARATOR . 'locations_map_sorted';
	protected const REDIS_PARAM_NAME_LIST = 'locations';
	
	public static function clear() {
		$item_keys = Redis::hGetAll(self::REDIS_PARAM_NAME_MAP);
		Redis::unlink($item_keys);
		Redis::unlink(self::REDIS_PARAM_NAME_MAP);
	}

	public static function add(array $item) {
		if (empty($item['loc_id'])) {
			return;
		}

		Redis::multi()
				->hMSet(self::redisParamNameItem($item['loc_id']), $item)
				->rPush(self::REDIS_PARAM_NAME_MAP, $item['loc_id'])
				->exec();
	}

	public static function sort($a, $b) {
		if (empty($a['loc_name']) || empty($b['loc_name'])) {
			return 0;
		}

		return strcmp($a['loc_name'], $b['loc_name']);
	}
	
	protected static function redisParamNameItem(int $id): string {
		return parent::REDIS_PARAM_NAME_ROOT . parent::REDIS_PARAM_SEPARATOR .
			self::REDIS_PARAM_NAME_LIST . parent::REDIS_PARAM_SEPARATOR . $id;
	}

}
