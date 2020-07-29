<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

abstract class CommonApiFactory {

	protected const REDIS_PARAM_NAME_ROOT = 'dataforseo';
	protected const REDIS_PARAM_SEPARATOR = ':';
	
	public static function clear() {
		Redis::unlink(self::keys());
		Redis::unlink(static::REDIS_PARAM_NAME_MAP);
	}
	abstract public static function add(array $item);
	abstract public static function sort($a, $b);
	abstract protected static function verboseFieldNames(): array;
	public static function redisParamNameItem(int $id): string {
		return self::REDIS_PARAM_NAME_ROOT . self::REDIS_PARAM_SEPARATOR .
			static::REDIS_PARAM_NAME_LIST . self::REDIS_PARAM_SEPARATOR . $id;
	}
	public static function keys(): array {
		$keys_raw = Redis::lRange(static::REDIS_PARAM_NAME_MAP, 0, -1);
		if (empty($keys_raw)) {
			return [];
		}
		
		return array_map(function($item_id) {
			return self::redisParamNameItem($item_id);
		}, $keys_raw);
	}
	public static function verbose(string $key) {
		return Redis::hMGet($key, static::verboseFieldNames());
	}
	public static function keysData() {
		foreach(static::keys() as $key) {
			yield self::verbose($key);
		}
	}
}
