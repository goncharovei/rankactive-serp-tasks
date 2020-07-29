<?php

namespace App\Models\DataForSeo;

use Illuminate\Support\Facades\Redis;

abstract class CommonApiFactory {

	protected const REDIS_PARAM_NAME_ROOT = 'dataforseo';
	protected const REDIS_PARAM_SEPARATOR = ':';
	
	abstract public static function clear();
	abstract public static function add(array $item);
	abstract public static function sort($a, $b);
	abstract protected static function redisParamNameItem(int $id): string;
}
