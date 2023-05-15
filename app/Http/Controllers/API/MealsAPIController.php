<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\{CreateMealRequest, UpdateMealRequest};

class MealsAPIController extends Controller
{
	/**
	 * Display a listing of the meals.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(): JsonResponse
	{
		// TODO: API resource and collection
		return response()->json(
			Meal::with('mealType:id,title')
				->paginate(15)
		);
	}

	/**
	 * Store a newly created meal in database.
	 *
	 * @param \App\Http\Requests\CreateMealRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateMealRequest $request): JsonResponse
	{
		Meal::create([
			'meal_type_id' => $request->meal_type_id,
			'quantity' => $request->quantity,
			'to_model_type' => $request->to_model_type,
			'to_model_id' => $request->to_model_id,
			'sent_at' => $request->sent_at,
		]);
		return response()->json(data: [
			'message' => __('Meal created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Display the specified meal.
	 *
	 * @param \App\Models\Meal $meal
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Meal $meal): JsonResponse
	{
		return response()->json($meal);
	}

	/**
	 * Update the specified meal in database.
	 *
	 * @param \App\Models\Meal $meal
	 * @param \App\Http\Requests\UpdateMealRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Meal $meal, UpdateMealRequest $request): JsonResponse
	{
		$meal->update([
			'meal_type_id' => $request->meal_type_id,
			'quantity' => $request->quantity,
			'to_model_type' => $request->to_model_type,
			'to_model_id' => $request->to_model_id,
			'sent_at' => $request->sent_at,
		]);
		return response()->json(status: 204); // No content
	}

	/**
	 * Remove the specified meal from database.
	 *
	 * @param \App\Models\Meal
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Meal $meal): JsonResponse
	{
		$meal->delete();
		return response()->json(status: 204); // No content
	}
}
