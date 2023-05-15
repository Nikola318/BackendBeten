<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Data;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
	/**
	 * Display a listing of countries.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(): JsonResponse
	{
		return response()->json(
			data: Country::select('id', 'title')->get()
		);
	}
}
