<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\{Request, ResponseTrait};
use Illuminate\Support\Facades\{Hash, Validator};

class RegisterAPIController extends \App\Http\Controllers\Controller
{
	use ResponseTrait;

	public function register(Request $request)
	{
		$input = $request->all();
		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string|max:200',
				'username' => 'required|unique:users',
				'contact' => 'required',
				'password' => 'required',
			]);
			if ($validator->fails()) {
				return response()->json([
					'status' => false,
					'message' => 'Please check all the required parameter',
					'response' => $validator->errors()], 422);
			}


			$user = User::create([
				'name' => $input['name'],
				'username' => $input['username'],
				'contact' => $input['contact'],
				'password' => Hash::make($input['password']),
				'is_active' => 1,
			]);
			$token = JWTAuth::fromUser($user);

			return response()->json([
				'status' => true,
				'message' => "Account Created Successfully.",
				'response' => [
					'user' => $user,
					'authorisation' => [
						'token' => $token,
						'type' => 'Bearer',
					]
				]], 200);


		} catch (\Exception $e) {
			$status = false;
			$message = "Server Error. " . $e->getMessage();
			$response = null;
			$status_code = 500;
			return response()->json($message,$status_code);
		}


	}
}
