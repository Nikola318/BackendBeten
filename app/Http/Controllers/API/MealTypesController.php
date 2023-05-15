<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\MealType;
use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request};
use App\Http\Requests\{CreateMealTypeRequest, UpdateMealTypeRequest};

class MealTypesController extends Controller
{
	/**
	 * Display a listing of the meal type.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$per_page = $request->input('per_page') ?? 15;
		$query = MealType::query();
		$request->whenFilled('title', function ($input) use ($query) {
			$query->where('title', 'LIKE', '%' . $input . '%');
		});
		return response()->json(data: $query->paginate($per_page));
	}

	/**
	 * Store a newly created meal type in database.
	 *
	 * @param \App\Http\Requests\CreateMealTypeRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateMealTypeRequest $request): JsonResponse
	{
		MealType::create($request->validated());
		return response()->json(data: [
			'message' => __('Meal type created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Display the specified meal type.
	 *
	 * @param \App\Models\MealType $mealType
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(MealType $mealType)
	{
		return response()->json($mealType);
	}

	/**
	 * Update the specified meal type in database.
	 *
	 * @param \App\Http\Requests\UpdateMealTypeRequest $request
	 * @param \App\Models\MealType $mealType
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateMealTypeRequest $request, MealType $mealType)
	{
		$mealType->update([
			'title' => $request->title,
			'description' => $request->description,
			'has_documents' => $request->has_documents,
		]);
		return response()->json(status: 204); // No content
	}

	/**
	 * Remove the specified meal type from database.
	 *
	 * @param \App\Models\MealType $mealType
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(MealType $mealType): JsonResponse
	{
		$mealType->delete();
		return response()->json(status: 204); // No content
	}
}
