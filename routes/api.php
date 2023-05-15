<?php

declare(strict_types=1);

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\{ConcurrentsController, ContractsAPIController, SettingsController};
use App\Http\Controllers\API\{
	CitiesController,
	ClientsAPIController,
	CrewsController,
	DocumentAPIController,
	DormitoriesController,
	GroupsController,
	HospitalitiesController,
	MealTypesController,
	MealsAPIController,
	PhasesController,
	ServiceAPIController,
	ServiceCommitsController,
	UsersController,
	VehicleAPIController
};

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here we register necessary API routes
| We only need POST /login & /password-confirm & /password/email & /password/reset
|
*/


Auth::routes();
Route::post('/verify/otp', [\App\Http\Controllers\Auth\LoginController::class, 'verifyOTPandLogin']);

Route::middleware('auth:sanctum')->group(function () {
	Route::post('/token-logout', [\App\Http\Controllers\Auth\LoginController::class, 'tokenLogout']);
	Route::get('countries', [\App\Http\Controllers\API\Data\CountriesController::class, 'index']);
	Route::get('/service_commits/initialize/{id}', [ServiceCommitsController::class, 'initialize']);
	Route::post('/service_commits/release', [ServiceCommitsController::class, 'release']);

	Route::post('/service_commit_log', [ServiceCommitsController::class, 'addLog']);
	Route::delete('/service_commit_log/{id}', [ServiceCommitsController::class, 'removeLog']);

	Route::get(
		'/my_service_commits',
		[ServiceCommitsController::class, 'myCommits']
	);

	Route::get('model_types', function () {
		return [
			"App\Models\Crew" => [
				'key' => __("App\\Models\\Crew"),
				'label' => 'fullname'
			],
			"App\Models\Hospitality" => [
				'key' => __("App\\Models\\Hospitality"),
				'label' => 'title'
			],
			"App\Models\Client" => [
				'key' => __("App\\Models\\Client"),
				'label' => 'fullname'
			],
			"App\Models\Dormitory" => [
				'key' => __("App\\Models\\Dormitory"),
				'label' => 'title'
			],
			"App\Models\MealType" => [
				'key' => __("App\\Models\\MealType"),
				'label' => 'title'
			],
			"App\Models\Group" => [
				'key' => __("App\\Models\\Group"),
				'label' => 'title'
			],
			"App\Models\Vehicle" => [
				'key' => __("App\\Models\\Vehicle"),
				'label' => 'model'
			],
		];
	});
	Route::get('ids_by_type/App/Models/{model_type}', function ($model_type) {
		$model = "App\Models\\" . $model_type;
		$label = [
			"App\Models\Crew" => [
				'key' => __("App\\Models\\Crew"),
				'label' => 'fullname'
			],
			"App\Models\Hospitality" => [
				'key' => __("App\\Models\\Hospitality"),
				'label' => 'title'
			],
			"App\Models\Client" => [
				'key' => __("App\\Models\\Client"),
				'label' => 'fullname'
			],
			"App\Models\Dormitory" => [
				'key' => __("App\\Models\\Dormitory"),
				'label' => 'title'
			],
			"App\Models\MealType" => [
				'key' => __("App\\Models\\MealType"),
				'label' => 'title'
			],
			"App\Models\Group" => [
				'key' => __("App\\Models\\Group"),
				'label' => 'title'
			],
			"App\Models\Vehicle" => [
				'key' => __("App\\Models\\Vehicle"),
				'label' => 'model'
			],
		][$model]['label'];
		// TODO: select the label dynamically...
		return (new $model)->select('id', "$label AS label")->get();
	});
	Route::get('/crews/all', [CrewsController::class, 'all']);
	Route::resource('/crews', CrewsController::class);
	Route::resource('/users', UsersController::class);
	Route::apiResource('/cities', CitiesController::class);
	Route::resource('/phases', PhasesController::class);
	Route::get('groups/all', [GroupsController::class, 'all']);
	Route::post('groups/clients', [GroupsController::class, 'addClients']);
	Route::delete('groups/clients', [GroupsController::class, 'removeClients']);
	Route::resource('/groups', GroupsController::class);
	Route::apiResource('/meals', MealsAPIController::class);
	Route::resource('/clients', ClientsAPIController::class);
	Route::apiResource('/services', ServiceAPIController::class);
	Route::apiResource('/meal_types', MealTypesController::class);
	Route::apiResource('/dormitories', DormitoriesController::class);
	Route::resource('/hospitalities', HospitalitiesController::class);
	Route::resource('/service_commits', ServiceCommitsController::class);

	/** Contracts */
	Route::controller(ContractsAPIController::class)->prefix('contracts')
		->group(function () {
			Route::get('/{type}/{id}', 'index');
			Route::post('/{type}/{id}', 'store');
			Route::delete('/{id}', 'destroy');
		});

	/** Concurrent */
	Route::controller(ConcurrentsController::class)->prefix('concurrents')
		->group(function () {
			Route::get('getusersroles', 'getusersroles');
			Route::get('/{type}/{id}', 'index');
			Route::post('/{type}/{id}', 'store');
			Route::delete('/{id}', 'destroy');
		});

	/** Documents */
	Route::controller(DocumentAPIController::class)->prefix('documents')
		->group(function () {
			Route::get('/{type}/{id}', 'index');
			Route::post('/{type}/{id}', 'store');
			Route::delete('/{id}', 'destroy');
		});

	Route::apiResource('settings', SettingsController::class);

	Route::controller(VehicleAPIController::class)->prefix('vehicles')
	   // ->middleware(['permission:manage_users'])
		->group(function () {
			Route::put('','store');
			Route::get('paginate','paginate');
			Route::get('info/{id}','show');
			Route::post('delete/{vehicle}','delete');
			Route::post('update/{id}','update');
			Route::post('add','store');

		});

	// Get available roles & crew members to select from when creating a user
	Route::get(
		'populate-create-user-dropdowns',
		[UsersController::class, 'populateCreateUserDropdowns']
	);
});
