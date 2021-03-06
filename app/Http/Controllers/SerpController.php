<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use \App\Models\DataForSeo\Locations;
use \App\Models\DataForSeo\SearchEngines;
use App\Models\DataForSeo\Serp\Tasks;

class SerpController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
		return view('home');
	}

	public function locationsGet(Request $request) {
		$result = [
			'items' => [],
			'success' => 0,
		];
		if (!$request->ajax()) {
			return response()->json($result);
		}

		$result['items'] = Locations::keysDataForJson($request->input('page', 0));
		$result['success'] = 1;

		return response()->json($result);
	}
	
	public function searchEnginesGet(Request $request) {
		$result = [
			'items' => [],
			'success' => 0,
		];
		if (!$request->ajax()) {
			return response()->json($result);
		}

		$result['items'] = SearchEngines::keysDataForJson($request->input('page', 0));
		$result['success'] = 1;

		return response()->json($result);
	}
	
	public function taskAdd(Request $request) {
		$result = [
			'success' => 0,
			'message_box' => ''
		];
		
		try {
			if (!$request->ajax()) {
				return redirect('/');
			}

			$request_data = $request->only(['se_id', 'loc_id', 'key']);
			$validator = Validator::make($request_data, [
				'se_id' => 'required|integer|min:1',
				'loc_id' => 'required|integer|min:1',
				'key' => 'required|string',
			]);
			if ($validator->fails()) {
				$result['message_box'] = view('includes.alert_danger', ['errors' => $validator->errors()->all()])->render();
				return response()->json($result);
			}
			
			$task = Tasks::create($validator->valid());
			if (empty($task->id)) {
				$result['message_box'] = view('includes.alert_danger',
						['errors' => [trans('task_creation_error')]])->render();
				return response()->json($result);
			}
			
			$dfs_service_response = resolve('DFSService')->srp_tasks_post([
				$task->id => $validator->valid()
			]);
			if (empty($dfs_service_response['results']) || !is_array($dfs_service_response['results'])) {
				$result['message_box'] = view(
					'includes.alert_danger',
					['errors' => [trans('task.dfs_error_method', ['method_name' => 'srp_tasks_post'])]]
				)->render();
				$task->delete();
				return response()->json($result);
			}
			$dfs_service_response = $dfs_service_response['results'];
			
			$post_id = array_key_first($dfs_service_response);
			$task->serp_task_id = $dfs_service_response[$post_id]['task_id'];
			$task->save();
			
			$result['success'] = 1;
			$result['message_box'] = view('includes.alert_success', ['message' => trans('task.task_successfully_created')])->render();
			
		} catch (\Exception $ex) {
			$logger = app(\Psr\Log\LoggerInterface::class);
			$logger->error(
				'error_text=' . $ex->getMessage() . "\n" .
				'error_trace=' . $ex->getTraceAsString()
			);
			
			$result['message_box'] = view(
				'includes.alert_danger',
				['errors' => [trans('task.something_went_wrong')]]
			)->render();
		}
		
		return response()->json($result);
	}
	
	public function taskList() {
		$pager_list_size = 50;
		$items = Tasks::latest()->paginate($pager_list_size);
		return view('tasks.list', compact('items'));
	}
	
	public function taskDetail(Tasks $task) {
		$pager_list_size = 50;
		$task_id = $task->id;
		$items = $task->results()->paginate($pager_list_size);
		return view('tasks.detail', compact('task_id', 'items'));
	}
	
}
