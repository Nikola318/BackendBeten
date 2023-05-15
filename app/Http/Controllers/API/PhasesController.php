<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\{Phase, Service};
use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Requests\{CreatePhaseRequest, UpdatePhaseRequest};

class PhasesController extends Controller
{
	/**
	 * Display a listing of the phases.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		// TODO: validate title & per_page formats (optional params)
		$query = Phase::orderby('id');
		$request->whenFilled('title', function ($input) use ($query) {
			$query->where('title', 'LIKE', '%' . $input . '%');
		});
		return response()->json($query->paginate(15));
	}

	/**
	 * Get data for the creation form of a phase
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create(): JsonResponse
	{
		return response()->json(data: Service::select('id', 'title')->get());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Requests\CreatePhaseRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreatePhaseRequest $request): JsonResponse
	{
		Phase::create([
			'title' => $request->title,
			'is_required' => $request->is_required,
		])->services()->attach($request->services);
		return response()->json(data: [
			'message' => __('Phase created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Display the specified phase.
	 *
	 * @param \App\Models\Phase $phase
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Phase $phase): JsonResponse
	{
		$phase->load(['services' => function (BelongsToMany $query): void {
			$query->select('id', 'title')->orderby('services.id');
		}]);
		return response()->json(data: $phase);
	}

	/**
	 * Update the specified phase in database.
	 *
	 * @param \App\Http\Requests\UpdatePhaseRequest $request
	 * @param \App\Models\Phase $phase
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(
		UpdatePhaseRequest $request,
		Phase $phase
	): JsonResponse
	{
		$phase->update([
			'title' => $request->title,
			'is_required' => $request->is_required,
		]);
		$phase->services()->sync($request->services);
		return response()->json(status: 204); // No content
	}

	public function assignServices(int $phase_id, array $services)
	{
		foreach ($services as $service_id) {
			PhaseService::create([
				'phase_id' => $phase_id,
				'service_id' => $service_id,
			]);
		}
	}

	public function clearPhaseServices($phase_id)
	{
		PhaseService::where('phase_id', $phase_id)->delete();
		return true;
	}


	/**
	 * Delete a phase from database.
	 *
	 * @param \App\Models\Phase $phase
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Phase $phase): JsonResponse
	{
		$phase->delete();
		return response()->json(status: 204); // No content
	}
}
