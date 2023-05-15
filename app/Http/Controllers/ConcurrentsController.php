<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Models\{Concurrent, ServiceCommit, User};
use App\Http\Requests\{CreateConcurrentRequest, DeleteConcurrentRequest};

class ConcurrentsController extends Controller
{
	/**
	 * Display a listing of the concurrents for a given model.
	 *
	 * @param string $type the model type
	 * @param int $id the model id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(string $type, int $id): JsonResponse
	{
		$type = 'App\Models\\' . Str::title($type);
		if ($type === 'App\Models\Servicecommit') {
			$type = ServiceCommit::class;
		}
		// If the model specified is not in the concurrents model types
		// Refuse the query
		if (! in_array($type, Concurrent::$model_types)) {
			return response()->json(status: 400); // Bad request
		}
		$concurrents = Concurrent::where([
				'model_type' => $type,
				'model_id' => $id,
			])->select(
				'id',
				'starting_at',
				'ending_at',
				'model_type',
				'model_id',
				'extra',
			)->get();
		return response()->json(data: $concurrents);
	}

	public function getusersroles()
	{
		$users = User::select('id', 'name')->where('is_active', true)->get();
		$roles = Role::select('id', 'name')->get();

		return response()->json(['users' => $users, 'roles' => $roles]);
	}

	/**
	 * Store newly created concurrent for a specific model in database.
	 *
	 * Note: segments are formatted and added to request data in the DTO
	 *
	 * @param \App\Http\Requests\CreateConcurrentRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateConcurrentRequest $request): JsonResponse
	{
		Concurrent::create($request->validated());
		return response()->json(data: [
			'message' => __('Concurrent created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Remove the specified concurrent from database.
	 *
	 * @param \App\Http\Requests\DeleteConcurrentRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DeleteConcurrentRequest $request): JsonResponse
	{
		Concurrent::where('id', $request->id)->delete();
		return response()->json(status: 204); // No content
	}
}
