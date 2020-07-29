<?php

namespace App\Models\DataForSeo\Serp;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {
	protected $table = 'serp_tasks';
	protected $fillable = [
		'se_id',
		'loc_id',
		'key',
	];
}
