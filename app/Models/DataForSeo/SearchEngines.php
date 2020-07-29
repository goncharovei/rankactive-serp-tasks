<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

class SearchEngines extends CommonApiFactory {

	protected const REDIS_PARAM_NAME_MAP = parent::REDIS_PARAM_NAME_ROOT .
			parent::REDIS_PARAM_SEPARATOR . 'search_engines_map_sorted';
	protected const REDIS_PARAM_NAME_LIST = 'search_engines';

	public static function clear() {
		$item_keys = Redis::hGetAll(self::REDIS_PARAM_NAME_MAP);
		Redis::unlink($item_keys);
		Redis::unlink(self::REDIS_PARAM_NAME_MAP);
	}

	public static function add(array $item) {
		if (empty($item['se_id'])) {
			return;
		}

		Redis::multi()
				->hMSet(self::redisParamNameItem($item['se_id']), $item)
				->rPush(self::REDIS_PARAM_NAME_MAP, $item['se_id'])
				->exec();
	}

	public static function sort($a, $b) {
		if (empty($a['se_name']) || empty($b['se_name'])) {
			return 0;
		}

		return strcmp($a['se_name'], $b['se_name']);
	}
	
	protected static function redisParamNameItem(int $id): string {
		return parent::REDIS_PARAM_NAME_ROOT . parent::REDIS_PARAM_SEPARATOR .
			self::REDIS_PARAM_NAME_LIST . parent::REDIS_PARAM_SEPARATOR . $id;
	}
}