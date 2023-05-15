<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\{Crew, User};
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\{UserDetailsResource, UserEditResource};
use App\Http\Requests\{CreateUserRequest, ListUsersRequest, UpdateUserRequest};

class UsersController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(User::class);
	}

	/**
	 * Display a listing of the users.
	 *
	 * @param \App\Http\Requests\ListUsersRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(ListUsersRequest $request): JsonResponse
	{
		$query = User::select('id', 'name', 'email', 'is_active', 'contact')
			->whereDoesntHave('roles', function (Builder $query): void {
				$query->where('name', 'admin');
			});

		foreach (['name', 'email', 'contact'] as $column) {
			$request->whenFilled($column, function ($input) use ($query, $column) {
				$query->where($column, 'LIKE', "%$input%");
			});
		}

		return response()->json(
			data: $query->paginate($request->input('per_page') ?? 15)
		);
	}

	/**
	 * Store a newly created user in database.
	 *
	 * @param \App\Http\Requests\CreateUserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateUserRequest $request): JsonResponse
	{
		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'is_active' => $request->is_active,
			'contact' => $request->contact,
		])->assignRole($request->roles);

		return response()->json(status: 201); // Created
	}

	/**
	 * Display the specified user with their roles.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(User $user): JsonResponse
	{
		return response()->json(
			data: new UserDetailsResource($user->load('roles:name'))
		);
	}

	/**
	 * Display the user for editing.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(User $user): JsonResponse
	{
		if ($user->is_admin) {
			return response()->json(status: 400);
		}
		if (request()->user()->can('roles')) {
			$user->load('roles:name');
		}

		return response()->json(
			data: [
				'user' => new UserEditResource($user),
				'roles' => request()->user()->can('roles') ? Role::select('name')
					->whereNot('name', 'admin')
					->get() : [],
			],
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateUserRequest $request
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdateUserRequest $request, User $user)
	{
		if ($user->is_admin) {
			return response()->json(status: 400);
		}

		$user->name = $request->name;
		$user->email = $request->email;
		$user->is_active = $request->is_active;
		$user->contact = $request->contact;

		// change password only if user entered a new one
		if ($request->has('password')) {
			$user->password = bcrypt($request->password);
		}

		$user->syncRoles($request->roles);

		$user->save();

		return response()->json(status: 202); // Accepted
	}

	/**
	 * Mark the specified user in database as deleted.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(User $user): JsonResponse
	{
		if ($user->is_admin) {
			return response()->json(status: 400);
		}
		if ($user->is(auth()->user())) {
			return response()->json(
				data: [
					'message' => __('Can not delete yourself.'),
				],
				status: 400
			);
		}
		$user->delete();
		return response()->json(status: 204); // No content
	}

	/**
	 * Populate user creation dropdowns
	 *
	 * Get available roles & crew members to select from when creating a user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 **/
	public function populateCreateUserDropdowns(): JsonResponse
	{
		return response()->json(data: [
			'roles' => Role::select('name')->pluck('name'),
			'crew_members' => Crew::select('id', 'fullname')->get(),
		]);
	}
}
