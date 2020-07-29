<?php

	namespace App\Services\DataForSeo;
	
	class DFSService {
		protected $client = null;
		protected $logger = null;
		protected $api_version = '';
		protected $country_iso_code_path = '';
		
		public function __construct(string $url_base, string $api_version, string $login, string $pass, string $country_iso_code, $logger = null) {
			$country_iso_code = trim($country_iso_code);
			if (empty($country_iso_code)) {
				throw new \Exception('"country_iso_code" not find');
			}
			
			$this->api_version = trim($api_version);
			$this->country_iso_code_path = '/' . $country_iso_code;
			$this->client = new RestClient($url_base, null, $login, $pass);
			$this->logger = $logger;
		}
		
		public function __call($method_name, $arguments) {
			if (!method_exists($this, $method_name)) {
				throw new \Exception($method_name . ' not available');
			}
			
			try {
				$result = !empty($arguments) ? $this->$method_name($arguments) : $this->$method_name();
				if ($result['status'] == 'error' || !isset($result['results'])) {
					$error_message = !empty($result['error']) && is_array($result['error']) ?
							print_r($result['error'], true) : 'Something went wrong';
					throw new \Exception($error_message);
				}
				
				$result = $result['results'];
			} catch (RestClientException $e) {
				$this->loggerSaveError(
					"\n" . 
					"HTTP code: {$e->getHttpCode()}\n" . 
					"Error code: {$e->getCode()}\n" . 
					"Message: {$e->getMessage()}\n" .
					$e->getTraceAsString() .
					"\n"
				);
				
				$result = [];
			} catch (\Exception $ex) {
				$this->loggerSaveError(
					"\n" . 
					"Error code: {$ex->getCode()}\n" . 
					"Message: {$ex->getMessage()}\n" .
					$ex->getTraceAsString() .
					"\n"
				);
				
				$result = [];
			}
			
			return $result;
		}
		
		protected function cmn_se(): array {
			return $this->client->get($this->api_version . __FUNCTION__ . $this->country_iso_code_path);
		}
		
		protected function cmn_locations(): array {
			return $this->client->get($this->api_version . __FUNCTION__ . $this->country_iso_code_path);
		}

		protected function loggerSaveError(string $text) {
			if (empty($this->logger) || !is_object($this->logger) || !method_exists($this->logger, 'error')) {
				error_log($text);
				return;
			}
			
			$this->logger->error($text);
		}
	}
	