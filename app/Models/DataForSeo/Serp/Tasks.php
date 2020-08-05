<?php

namespace App\Models\DataForSeo\Serp;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataForSeo\SearchEngines;
use App\Models\DataForSeo\Locations;

class Tasks extends Model {

	protected $table = 'serp_tasks';
	protected $fillable = [
		'se_id',
		'loc_id',
		'key',
	];

	public function results() {
		return $this->hasMany(TaskResults::class, 'task_id', 'id');
	}
	
	public function getEngineNameAttribute(): string {
		return empty($this->se_id) ? '' : SearchEngines::verbose($this->se_id);
	}
	
	public function getLocationNameAttribute(): string {
		return empty($this->loc_id) ? '' : Locations::verbose($this->loc_id);
	}
	
	public function processed() {
		$this->is_processed = true;
		$this->save();
	}
}
