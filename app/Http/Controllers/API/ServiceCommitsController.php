<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request};
use App\Models\{Service, ServiceCommit, Service_Commit_Log, User};
use App\Http\Requests\{AddLogRequest, CreateServiceCommitRequest, ReleaseServiceCommitRequest, UpdateServiceCommitRequest};

class ServiceCommitsController extends Controller
{
	/**
	 * Display a listing of the service commits.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(): JsonResponse
	{
		$commits = ServiceCommit::select(
			'id',
			'service_id',
			'badge',
			'schedule_at',
			'started_at',
			'from_location',
			'supervisor_id',
			'phase_id'
		)->with(['service:id,title', 'supervisor:id,name', 'phase:id,title'])->paginate(15);
		return response()->json($commits);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(ServiceCommit $serviceCommit): JsonResponse
	{
		return response()->json([
			'commit' => $serviceCommit->load('service'),
			'logs' => $serviceCommit->service_commit_log()->paginate(5)
		]);
	}

	/**
	 * Get the data for the form for creating a new service commit.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create(): JsonResponse
	{
		return response()->json([
			'users' => User::select('id', 'name')->get(),
			'services' => Service::select('id', 'title')->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateServiceCommitRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateServiceCommitRequest $request): JsonResponse
	{
		ServiceCommit::create($request->validated());
		return response()->json(data: [
			'message' => __('Service commit created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Get the data for the form for editing a service commit.
	 *
	 * @param \App\Models\ServiceCommit $commit
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(ServiceCommit $serviceCommit): JsonResponse
	{
		return response()->json(data: [
			'commit' => $serviceCommit,
			'users' => User::select('id', 'name')->get(),
			'services' => Service::select('id', 'title')->get(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\UpdateServiceCommitRequest $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdateServiceCommitRequest $request, int $id): JsonResponse
	{
		$service_commit = ServiceCommit::select('id')
			->where('id', $id)
			->first();
		// Request data already validated from the form request class
		$service_commit->service_id = $request->service_id;
		$service_commit->badge = $request->badge;
		$service_commit->schedule_at = $request->schedule_at;
		$service_commit->started_at = $request->started_at;
		$service_commit->from_location = $request->from_location;
		$service_commit->supervisor_id = $request->supervisor_id;
		// Save in the database
		$service_commit->save();
		return response()->json(status: 204); // No content
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
		ServiceCommit::whereId($id)->delete();
		return response()->json(status: 204);
	}

	public function myCommits(Request $request)
	{
		if ($request->user()->is_admin) {
			return ServiceCommit::select(
				'id',
				'service_id',
				'badge',
				'schedule_at',
				'started_at',
				'from_location',
				'supervisor_id',
				'phase_id'
			)->with(['service:id,title', 'supervisor:id,name', 'phase:id,title'])->get();
		}
		return auth()->user()->service_commits()->with('service')->get();
	}

	/**
	 * Add logs to service commit
	 *
	 * @param \App\Http\Requests\AddLogRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function addLog(AddLogRequest $request): JsonResponse
	{
		Service_Commit_Log::create([
			'service_commit_id' => $request->service_commit_id,
			'model_type' => $request->model_type,
			'model_id' => $request->model_id,
			'role' => $request->role,
		]);
		return response()->json(status: 201); // Created
	}

	/**
	 * Remove a log from service commit
	 *
	 * @param int $id ID of the service commit log to delete.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function removeLog(int $id): JsonResponse
	{
		Service_Commit_Log::whereId($id)->delete();
		return response()->json(status: 204); // No content
	}

	public function initialize($id)
	{
		ServiceCommit::find($id)->update([
			'started_at' => now(),
		]);
	}

	/**
	 * Release the service commit.
	 *
	 * Sets the ended_at time to the current UNIX timestamp.
	 *
	 * @param \App\Http\Requests\ReleaseServiceCommitRequest $request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function release(ReleaseServiceCommitRequest $request): JsonResponse
	{
		ServiceCommit::where('id', $request->id)->update([
			'ended_at' => now(),
		]);
		return response()->json(status: 204); // No content
	}
}
