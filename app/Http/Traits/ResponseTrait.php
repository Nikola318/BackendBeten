<?php

declare(strict_types=1);

namespace App\Http\Traits;

/**
 * Trait function for common response
 */
trait ResponseTrait {
	public function sendResponse($result,$sucess,$message,$data,$totalRecord=0,$additionData=null) {
		return response()->json([
				'result'        => $result,
				'success'       =>  $sucess,
				'message'       => $message,
				'data'          =>  $data,
				'status_code'   => 200,
				'totalRecords'  => $totalRecord,
				'additionData'  =>$additionData

	   ]);
   }


	/**
	 * return error response.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sendError($error_message, $error_description , $status_code)
	{
		return response()->json([
			'error_message'       => $error_message,
			'error_description'   =>  $error_description,
			'status_code'     =>$status_code
		], $status_code ?? 500);
	}
	/**
	 * return error response.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sendValidationError($error_message, $error_description, $status_code,  $errors)
	{
		return response()->json([
			'error_message'       => $error_message,
			'error_description'   =>  $error_description,
			'status_code'     =>$status_code,
			'errors'     =>$errors
		],422);
	}


	public function sendResponseDatatable($result,$sucess,$message,$arrayYajra) {
		return response()->json( ([
			'result'        => $result,
			'success'       =>  $sucess,
			'message'       => $message,
			'status_code'   => 200,
			'data'   => $arrayYajra,
		]));
	}

	public function sendResponseReport($result, $sucess, $message, $data, $totalRecord, $statistics) {
		return response()->json( ([
			'result'        => $result,
			'success'       =>  $sucess,
			'message'       => $message,
			'data'          =>  $data,
			'status_code'   => 200,
			'totalRecords'  => $totalRecord,
			'statistics'  => $statistics
		]));
	}
}
