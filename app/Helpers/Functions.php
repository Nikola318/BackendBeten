<?php

declare(strict_types=1);

/*************************************
 *	safeResponse
 *		return json string of data sent
 *	Arguments
 *		$data, $code [ default 200, otherwise its error], $has_error [to inform reception]
 *	Todo - split this function to safeResponseData, safeResponseMessage, safeResponseError - WITH redirect option
 *
 ************************************/
if( ! function_exists('safeResponse') )
{
	function safeResponse($data, $code = 200, $has_error = false)
	{
		if( request()->ajax() ) {
			if( $has_error === true )
				return response()->json(["error"=>$data, "code"=>$code, "has_error"=>true,]);
			else
				return response()->json(["data"=>$data, "code"=>$code]);
		}
		else	{
			if( $has_error === true )
				return $data;
			return $data;
		}
	}
}
/**
 * Get array of eloquent models in the application
 *
 * Iterates through the app/Models directory
 *
 * @param Type $var Description
 * @return type
 * @throws conditon
 **/
if (! function_exists('getModels')) {
	function getModels() {
		$path = app_path() . "/Models";
		$out = [];
		$results = scandir($path);
		foreach ($results as $result) {
			if ($result === '.' or $result === '..') {
				continue;
			}
			$filename = $path . '/' . $result;
			if (is_dir($filename)) {
				$out = array_merge($out, getModels($filename));
			} else {
				$out[] = substr($filename, 0, -4);
			}
		}
		return $out;
	}
}

/**
 * Using Taqnyat SMS provider to send SMS
 *
 * 
 * @param array $recipients which phone number(s) of receptions
 * @param string $body sms message body
 * @return type
 * @throws conditon
 **/
if (! function_exists('taqnyatSendSmsMsg')) {
	function taqnyatSendSmsMsg($body, $recipients) {
		$taqnyt = new \App\Helpers\TaqnyatSms(config('eogsoft.gateways.sms.taqnyat.bearer'));
		$message = $taqnyt->sendMsg($body, $recipients, config('eogsoft.gateways.sms.taqnyat.sender'));
        // \Log::useFiles(storage_path() . '/logs/sms_messages.log'); // to save to seprate file 
		Illuminate\Support\Facades\Log::info($message);
		return true;
	}
}
