<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateDocumentRequest;

class DocumentAPIController extends Controller
{
	/**
	 * Display a listing of the documents for a given model.
	 *
	 * @param string $type the model type
	 * @param int $id the model id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(string $type, int $id): JsonResponse
	{
		$type = 'App\Models\\' . Str::title($type);
		// If the model specified is not in the document model types
		// Refuse the query
		if (! in_array($type, Document::$model_types)) {
			return response()->json(status: 400); // Bad request
		}
		$documents = Document::with('creator:id,name')
			->where([
				'model_type' => $type,
				'model_id' => $id,
			])->select(
				'id',
				'title',
				'path',
				'model_type',
				'model_id',
				'created_by',
				'created_at',
				'deleted_by',
				'deleted_at'
			)->get();
		return response()->json(DocumentResource::collection($documents));
	}

	/**
	 * Store a newly created document in database.
	 *
	 * @param \App\Http\Requests\CreateDocumentRequest $request
	 *
	 * Note: segments are formatted and added to request data in the DTO
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateDocumentRequest $request): JsonResponse
	{
		// Iterate through the documents files in the request
		foreach ($request->documents as $document) {
			// We can't get the dynamic model to attach contracts for
			// But we have the class name, so we invert the operation
			// Create a new document from each of the files
			Document::create([
				'title' => $request->title,
				'path' => $document->store('documents'),
				'model_type' => $request->model_type, // Pass the model type, namespaced
				'model_id' => $request->model_id, // Pass the model ID
				'created_by' => auth()->id(),
			]);
		}
		return response()->json(data: [
			'message' => __('Document created successfully!'),
		], status: 201); // Created
	}

	/**
	 * Remove the specified document from database.
	 *
	 * @param int $id The ID of the document to delete.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
		// TODO: move validation to form request
		Validator::make(['id' => $id], [
			'id' => 'bail|required|integer|exists:documents,id'
		])->validate();
		Document::where('id', $id)->delete();
		return response()->json(status: 204); // No content
	}
}
