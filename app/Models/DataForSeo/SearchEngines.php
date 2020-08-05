<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

class SearchEngines extends CommonApiFactory {

	protected const REDIS_PARAM_NAME_MAP = parent::REDIS_PARAM_NAME_ROOT .
			parent::REDIS_PARAM_SEPARATOR . 'search_engines_map_sorted';
	protected const REDIS_PARAM_NAME_LIST = 'search_engines';
	protected const REDIS_PAGE_SIZE = 500;
	
	public static function add(array $item) {
		if (empty($item['se_id'])) {
			return;
		}

		Redis::multi()
				->hMSet(parent::redisParamNameItem($item['se_id']), $item)
				->rPush(self::REDIS_PARAM_NAME_MAP, $item['se_id'])
				->exec();
	}

	public static function sort($a, $b) {
		if (empty($a['se_name']) || empty($b['se_name'])) {
			return 0;
		}

		return strcmp($a['se_name'], $b['se_name']);
	}
	
	protected static function verboseFieldNames(): array {
		return ['se_id', 'se_name', 'se_language'];
	}
	
	public static function verbose(int $item_id): string {
		if ($item_id <= 0) {
			return '';
		}
		
		$key = static::redisParamNameItem($item_id);
		$item = static::keyData($key);
		if (empty($item['se_name']) || empty($item['se_language']) || empty($item['se_id'])) {
			return '';
		}
		
		return $item['se_name'] . ' (' . $item['se_language'] . '). ID=' . $item['se_id'];
	}
	
}
