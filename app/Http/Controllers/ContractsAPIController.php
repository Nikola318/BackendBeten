<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Models\{Contract, Document};
use App\Http\Resources\ContractResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateContractRequest;

class ContractsAPIController extends Controller
{
	/**
	 * Display a listing of the contracts for a given model.
	 *
	 * @param string $type the model type
	 * @param int $id the model id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(string $type, int $id): JsonResponse
	{
		$type = 'App\Models\\' . Str::title($type);
		// If the model specified is not in the contract model types
		// Refuse the query
		if (! in_array($type, Contract::$model_types)) {
			return response()->json(status: 400); // Bad request
		}
		$contracts = Contract::where([
				'model_type' => $type,
				'model_id' => $id,
			])->select(
				'id',
				'reference',
				'model_type',
				'model_id',
				'extra',
				'created_by',
				'created_at',
				'deleted_by',
				'deleted_at'
			)->get();
		return response()->json(ContractResource::collection($contracts));
	}

	/**
	 * Store newly created contracts for a specific model in database.
	 *
	 * @param \App\Http\Requests\CreateContractRequest $request
	 *
	 * Note: segments are formatted and added to request data in the DTO
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateContractRequest $request)
	{
		/*
		 * Create one contract for the reference and related model type
		 * We're assigning a contract_id variable to avoid name conflict
		 * with the iteration underneath, as well as reducing memory usage
		 * i.e we're not holding a gigantic object but just a single primitive
		 * data type
		 */
		$contract_id = Contract::create([
			'reference' => $request->reference,
			'model_type' => $request->model_type,
			'model_id' => $request->model_id,
			// TODO: we may need to put file metadata in an extra column
			// 'extra' => 'To be implemented',
			'created_by' => auth()->id(),
		])->id;
		// Iterate through the contracts files in the request
		foreach ($request->contracts as $contract) {
			/**
			 * A contract is an arbitrary record in the database
			 * i.e it does not hold actual files
			 * We create multiple documents that do, belonging to the contract
			 * But the contract record itself belong to the model type coming
			 * from the request, this also explains why Contract model uses
			 * the trait HasDocuments
			 */
			Document::create([
				/*
				 * All the documents will have the one contract reference
				 * as their title
				 */
				'title' => $contract->getClientOriginalName(),
				'path' => $contract->store('documents'),
				'model_type' => Contract::class,
				'model_id' => $contract_id,
				'created_by' => auth()->id(),
			]);
		}
		return response()->json(data: [
			'message' => __('Contract created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Remove the specified contract from database.
	 *
	 * @param int $id The ID of the contract to delete.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
		// TODO: move validation to form request
		Validator::make(['id' => $id], [
			'id' => 'bail|required|integer|exists:contracts,id'
		])->validate();
		Contract::where('id', $id)->delete();
		// Soft delete related documents
		Document::where([
			'model_type' => Contract::class,
			'model_id' => $id,
		])->delete();
		return response()->json(status: 204); // No content
	}
}
