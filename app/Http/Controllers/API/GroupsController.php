<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request};
use App\Models\{Client, ClientLog, Crew, Group};
use App\Http\Requests\{
	AddClientsToGroupRequest,
	CreateGroupRequest,
	RemoveClientsFromGroupRequest,
	UpdateGroupRequest
};

class GroupsController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Group::class);
	}

	/**
	 * Display a listing of the groups.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$groups = Group::query();

		$request->whenFilled('title', function ($input) use ($groups) {
			$groups->where('title', 'LIKE', '%' . $input . '%');
		});

		$request->whenFilled('crew_member', function ($input) use ($groups) {
			// Get IDs of crew members starting with the query string value
			$crew_members_ids = Crew::select('id')
				->where('fullname', 'LIKE', '%' . $input . '%')
				->limit(50) // Reasonable limit, this gets hit on keyup
				->pluck('id');
			$groups->whereIn('crew_id', $crew_members_ids);
		});

		if (!$request->user()->can('groups.index') && $request->user()->is_supervisor) {
			$groups->where(
				'crew_id', Crew::select('id')
					->where('user_id', $request->user()->id)
					->value('id')
			);
		}

		return response()->json(
			// Only eager load what's necessary for display
			data: $groups->with('crew:id,user_id,fullname')
				->withCount('clients')
				->paginate(15)
		);
	}

	/**
	 * Get all groups
	 *
	 * List all groups for selection
	 *
	 * @return Illuminate\Http\JsonResponse
	 **/
	public function all(): JsonResponse
	{
		return response()->json(data: Group::select('id', 'title')->get());
	}

	/**
	 * Store a newly created group in database.
	 *
	 * @param \App\Http\Requests\CreateGroupRequest
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateGroupRequest $request): JsonResponse
	{
		Group::create($request->validated());
		return response()->json(data: [
			'message' => __('Group created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Display the specified group.
	 *
	 * @param \App\Models\Group $group
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Group $group): JsonResponse
	{
		return response()->json(
			data: $group->load(
				// Returning the user_id for authorization
				'crew:id,user_id,fullname',
				'clients:id,group_id,fullname,country_id,id_type,id_number,id_name,gender,dob,phone'
			)
		);
	}

	/**
	 * Get the data for the form for editing a group.
	 *
	 * @param \App\Models\Group $group
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(Group $group): JsonResponse
	{
		return response()->json(data: [
			'group' => $group,
			'crew_members' => Crew::select('id', 'fullname')->get(),
		]);
	}

	/**
	 * Update the specified group in database.
	 *
	 * @param \App\Models\Group $group
	 * @param \App\Http\Requests\UpdateGroupRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Group $group, UpdateGroupRequest $request): JsonResponse
	{
		$group->update($request->validated());
		return response()->json(status: 202); // Accepted
	}

	/**
	 * Add clients to the group
	 *
	 * Update an array of clients setting their group_id to the current group
	 *
	 * @param \App\Http\Requests\AddClientsToGroupRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 **/
	public function addClients(AddClientsToGroupRequest $request): JsonResponse
	{
		Client::whereIn('id', $request->clients)
			/**
			 * Extra filter just in case
			 * It's so we avoid overriding existing clients
			 */
			->whereNull('group_id')
			->update([
				'group_id' => $request->group_id,
			]);
		// Log the assignment in each client
		// value is the title of the group
		// key is assigned_group
		foreach ($request->clients as $client) {
			ClientLog::create([
				'client_id' => $client,
				'model_type' => Group::class,
				'model_id' => $request->group_id,
				'key' => 'assigned_group',
				'value' => Group::select('title')
					->where('id', $request->group_id)
					->value('title')
			]);
		}
		return response()->json(status: 202); // Accepted
	}

	/**
	 * Remove clients from the group
	 *
	 * Update an array of clients setting their group_id to null
	 *
	 * @param \App\Http\Requests\RemoveClientsFromGroupRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 **/
	public function removeClients(
		RemoveClientsFromGroupRequest $request
	): JsonResponse {
		Client::whereIn('id', $request->clients)
			/**
			 * Extra filter just in case
			 * It's so we avoid unassigning unrelated clients
			 */
			->where('group_id', $request->group_id)
			->update([
				'group_id' => null,
			]);
		// Log the removal of each client
		// value is the title of the group
		// key is removed_group
		foreach ($request->clients as $client) {
			ClientLog::create([
				'client_id' => $client,
				'model_type' => Group::class,
				'model_id' => $request->group_id,
				'key' => 'removed_group',
				'value' => Group::select('title')
					->where('id', $request->group_id)
					->value('title')
			]);
		}
		return response()->json(status: 204); // No content
	}

	/**
	 * Remove the specified group from database.
	 *
	 * @param \App\Models\Group $group
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Group $group): JsonResponse
	{
		$group->delete();
		return response()->json(status: 204); // No content
	}
}
