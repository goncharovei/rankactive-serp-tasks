<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

abstract class CommonApiFactory {

	protected const REDIS_PARAM_NAME_ROOT = 'dataforseo';
	protected const REDIS_PARAM_SEPARATOR = ':';
	protected const REDIS_PARAM_NAME_MAP = self::REDIS_PARAM_NAME_ROOT .
			self::REDIS_PARAM_SEPARATOR . 'map_sorted';
	protected const REDIS_PARAM_NAME_LIST = 'list';
	protected const REDIS_PAGE_SIZE = 20;
	
	public static function clear() {
		Redis::unlink(static::keys());
		Redis::unlink(static::REDIS_PARAM_NAME_MAP);
	}

	abstract public static function add(array $item);

	abstract public static function sort($a, $b);

	abstract protected static function verboseFieldNames(): array;

	public static function redisParamNameItem(int $id): string {
		return self::REDIS_PARAM_NAME_ROOT . self::REDIS_PARAM_SEPARATOR .
				static::REDIS_PARAM_NAME_LIST . self::REDIS_PARAM_SEPARATOR . $id;
	}

	public static function keys(int $page_number = 1): array {
		if ($page_number <= 0) {
			return [];
		}
		
		$list_size = static::listSize();
		$number_start = static::REDIS_PAGE_SIZE * ($page_number - 1);
		if ($number_start >= $list_size) {
			return [];
		}
		
		$number_end = (static::REDIS_PAGE_SIZE * $page_number) - 1;
		if ($number_end + 1  >= $list_size) {
			$number_end = -1;
		}
		
		$keys_raw = Redis::lRange(static::REDIS_PARAM_NAME_MAP, $number_start, $number_end);
		if (empty($keys_raw)) {
			return [];
		}

		return array_map(function($item_id) {
			return static::redisParamNameItem($item_id);
		}, $keys_raw);
	}

	public static function verbose(string $key) {
		return array_combine(
			static::verboseFieldNames(),
			Redis::hMGet($key, static::verboseFieldNames())
		);
	}
	
	public static function keysData(int $page_number = 1):array {
		$result = [];
		foreach(static::keys($page_number) as $key) {
			$result[] = static::verbose($key);
		}
		
		return $result;
	}
	
	public static function listSize(): int {
		return Redis::lLen(static::REDIS_PARAM_NAME_MAP);
	}
}
