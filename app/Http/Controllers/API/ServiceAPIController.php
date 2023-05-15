<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\{CreateServiceRequest, UpdateServiceRequest};

class ServiceAPIController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Service::class);
	}

	/**
	 * Display a listing of the services.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(): JsonResponse
	{
		$services = Service::select(
			'id',
			'title',
			'city_id',
			'before_date',
			'exact_date',
			'after_date'
		)->with('city:id,title')->paginate(15);

		return response()->json(data: $services, status: 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Service $service): JsonResponse
	{
		return response()->json(data: $service);
	}

	/**
	 * Store a newly created service in database.
	 *
	 * @param \App\Http\Requests\CreateServiceRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateServiceRequest $request): JsonResponse
	{
		Service::create([
			'title' => $request->title,
			'city_id' => $request->city_id,
			'before_date' => $request->before_date,
			'exact_date' => $request->exact_date,
			'after_date' => $request->after_date,
		]);

		return response()->json(data: [
			'message' => __('Service created successfully!'),
		], status: 201);
	}

	/**
	 * Update the specified service in database.
	 *
	 * @param \App\Http\Requests\UpdateServiceRequest $request
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(
		UpdateServiceRequest $request,
		Service $service
	): JsonResponse
	{
		$service->update([
			'title' => $request->title,
			'city_id' => $request->city_id,
			'before_date' => $request->before_date,
			'after_date' => $request->after_date,
			'exact_date' => $request->exact_date,
		]);
		return response()->json(status: 202); // Accepted
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id)
	{
		$crew = Service::find($id)->delete($id);

		return response()->json(([
			'message'       => 'services Deleted Successfully',
			'data'          =>  null,
			'status_code'   => 200,
		]));
	}
}
