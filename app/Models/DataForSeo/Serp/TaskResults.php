<?php

namespace App\Models\DataForSeo\Serp;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {
	protected $table = 'serp_task_results';
	protected $fillable = [
		'loc_id',
		'post_key',
		'result_url',
		'result_title',
		'status',
	];
}
