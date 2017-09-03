<?php
use Illuminate\Http\Response;


 
 
function type_format($value){
	if($value == 2){
		return '套系';
	}
	else if($value == 3){
		return '活动';
	}else{
		return '';
	}
}
 
function format_price($value){
	return sprintf("%0.2f",$value/100);
} 
 
 
function company_id(){
    return Auth::user() ? Auth::user()->company_id : 0;
}


function encrypt_company($value){
    $en_value = $value * 4313 + 20154;
    return $en_value;
}

function decrypt_company($value){
    $de_value = ($value - 20154)/4313;
    return $de_value;
}


/**
 * Hash encrypted string
 *
 * @param string|integer $id
 * @return hash|string
 */
function hash_encode($id) {
    return Hashids::encode($id);
}

/**
 * Decode hash encrypted string
 *
 * @param string $id
 * @return bool
 */
function hash_decode($id) {
    $decode = Hashids::decode($id);
    return $decode ? $decode[0] : false;
}

/**
 * recover file path
 *
 * @param $url
 * @return string
 */
function cdn($url) {
    return env('APP_CDN') . $url;
}

/**
 * Response successfully message
 *
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\Response
 */
function success($message = '', $data = []) {
    return response()->make([
        'status'  => 0,
        'message' => $message,
        'data'    => $data
    ], Response::HTTP_OK);
}

/**
 * Response error message
 *
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\Response
 */
function error($message = '', $data = []) {
    return response()->make([
        'status'  => 400,
        'message' => $message,
        'data'    => $data
    ], Response::HTTP_BAD_REQUEST);
}

/**
 * Response un processable message
 *
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\Response
 */
function un_processable($message = '', $data = []) {
    return response()->make([
        'status'  => 422,
        'message' => $message,
        'data'    => $data
    ], Response::HTTP_UNPROCESSABLE_ENTITY);
}
