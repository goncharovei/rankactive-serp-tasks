<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DataForSeo\DFSService;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		
		$this->app->singleton('DFSService', function ($app) {
			
			return new DFSService(
				config('dataforseo.url'),
				config('dataforseo.api_version'),	
				config('dataforseo.login'),	
				config('dataforseo.password'),
				config('dataforseo.country_iso_code'),
				\Illuminate\Support\Facades\Log::channel('dataforseo')
			);
		});
		
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

}
