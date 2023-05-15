<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Client, Complaint, Crew};

class ComplaintAPIController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Complaint::class);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		if ($this->authUser->hasPermissionTo('complaints.index')) {

			$clients = Complaint::paginate($request->input('per_page')?? 15);

			return response()->json(([
				'message' => 'Complaints list',
				'data' => $clients,
				'status_code' => 200,
			]));
		} else {
			return response()->json('dont have permission to see Complaints', 402);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		if ($this->authUser->hasPermissionTo('complaints.create')) {
			Validator::make(
				$request->all(),
				$this->validationRules()
			)->validate();

			$client = Complaint::create([
				'title'=> $request->post('title'),
				'referfence'=> $request->post('referfence'),
				'comment'=> $request->post('comment'),
				'created_by'=> $this->userId,
			]);

			return response()->json( ([
				'message'       => 'Complaints Created Successfully',
				'data'          =>  $client,
				'status_code'   => 200,
			]));
		} else {
			return  response()->json('dont have permission to add complaints', 402);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Complaint $complaint
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($id)
	{
		if ($this->authUser->hasPermissionTo('complaints.view')) {
			$crew = Complaint::find($id);
			return response()->json( ([
				'message'       => 'Crew Details',
				'data'          =>  $crew,
				'status_code'   => 200,
			]));
		} else {
			return  response()->json('dont have permission to view complaints', 402);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Complaint $complaint
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Complaint $complaint)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Complaint $complaint
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id)
	{
		if ($this->authUser->hasPermissionTo('complaints.delete')) {
			$crew = Complaint::delete($id);

			return response()->json( ([
				'message'       => 'complaints Deleted Successfully',
				'data'          =>  null,
				'status_code'   => 200,
			]));
		} else {
			return  response()->json('dont have permission to delete complaints', 402);
		}
	}

	private function validationRules()
	{
		$result = [
			'title' => 'required',
			'referfence' => 'required',
			'comment' => 'required',
		];

		return $result;
	}
}
