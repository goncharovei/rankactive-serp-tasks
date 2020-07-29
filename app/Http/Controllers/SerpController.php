<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class SerpController extends Controller {


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
		return view('home');
	}


}
