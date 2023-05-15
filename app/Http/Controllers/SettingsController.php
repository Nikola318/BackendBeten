<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\{JsonResponse, Request};

class SettingsController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Setting::class);
	}
	/**
	 * Display a listing of the settings.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(): JsonResponse
	{
		return response()->json(Setting::get());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Setting $setting
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Setting $setting)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Setting $setting
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Setting $setting)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Setting $setting
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Setting $setting)
	{
		//
	}
}
