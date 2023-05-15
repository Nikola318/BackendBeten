<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request};
use App\Http\Requests\{CreateVehicleRequest, UpdateVehicleRequest};

class VehicleAPIController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Vehicle::class);
	}

	public function paginate(Request $request)
	{
		$query = Vehicle::query();

		foreach (['model', 'manufacturer', 'registration'] as $column) {
			$request->whenFilled($column, function ($input) use ($query, $column) {
				$query->where($column, 'LIKE', "%$input%");
			});
		}
		return response()->json($query->paginate(15));
	}

	/**
	 * Store a newly created vehicle in database.
	 *
	 * @param \App\Http\Requests\CreateVehicleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateVehicleRequest $request): JsonResponse
	{
		Vehicle::create($request->validated());
		return response()->json(status: 201); // Created
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Service  $vehicle
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$vehicle = Vehicle::findorfail($id);
		return response()->json($vehicle);
	}

	/**
	 * Update the specified vehicle in database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(
		UpdateVehicleRequest $request,
		Vehicle $vehicle
	): JsonResponse
	{
		$vehicle->update($request->validated());
		return response()->json(status: 202);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Vehicle $vehicle
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Vehicle $vehicle)
	{
		$vehicle->forceDelete();
		return response()->json(status: 204);
	}
}
