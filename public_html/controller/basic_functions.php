<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 17.04.2017
 * Time: 19.59
 */

function redirect($url, $permanent = false, $statusCode = 303, $out=false){
    // echo $GLOBALS['server_url'] . $url;
    if($out){
        echo $GLOBALS['server_url'].$url;
        exit();
    }

    header('Location: ' . $GLOBALS['server_url']. $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . $url, $permanent, $statusCode);
    die();
}

function getPasswordHash($password){

    return password_hash( $password, PASSWORD_DEFAULT );
}

/*
 * Solution taken from:
 *
 * http://stackoverflow.com/questions/965611/forcing-access-to-php-incomplete-class-object-properties
 */
function fixObject (&$object)
{
    if (!is_object ($object) && gettype ($object) == 'object')
        return ($object = unserialize (serialize ($object)));
    return $object;
}


function getParamFromQueryString($str, $key){
    $arr = explode('&',$str);
    if(count($arr)>0)
        foreach($arr as $a){
            $keyvals = explode('=',$a);
            if(count($keyvals)>0 && $keyvals[0] == $key)
                return (count($keyvals)>1)? $keyvals[1] : '';
        }
    else{
        $keyvals = explode('=',$arr);
        if(count($keyvals)>0 && $keyvals[0] == $key)
            return (count($keyvals)>1)? $keyvals[1] : '';
    }
    return '';
}

function subArray(array $arr, int $start, int $len) : array{
	if($start < 0 || $start >= sizeof($arr)){
		return array();
	}
	$ret = array();
	$len = min($len, sizeof($arr) - $start);
	for($i = 0; $i < $len; $i++){
		$ret[$i] = $arr[$start+$i];
	}
	return $ret;
}

function uploadImage(/*string*/$inputName){
	/*
	 * Image uploading example from
	 * https://www.w3schools.com/php/php_file_upload.asp
	 */
	$target_dir = __DIR__."/uploaded-imgs/";
	$filename = basename($_FILES[$inputName]["name"]);
	$target_file = $target_dir . $filename;
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	$check = getimagesize($_FILES[$inputName]["tmp_name"]);
	if($check !== false){
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
		// TODO: Code for fake image
	}

	if(file_exists($target_file)){
		$uploadOk = 0;
		// TODO: Code for already existing file
	}

	if($_FILES[$inputName]["size"] > IMAGE_SIZE_LIMIT){
		$uploadOk = 0;
		// TODO: Code for too big image file
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
		$uploadOk = 0;
		// TODO: Code for wrong file extension
	}

	if($uploadOk == 0){
		// TODO: IMPORTANT, handle case where image upload failed
	} else {
		if(move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)){
			// TODO: file uploaded
			return $filename;
		} else {
			// TODO: In case of unexpected error while uploading
		}
	}
	return 0;
}