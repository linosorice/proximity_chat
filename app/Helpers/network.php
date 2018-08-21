<?php

// GRUPPI
// **************
// Creates a new private group
function createGroup($request, $group_name) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'groups.create', array('name'=>$group_name));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'groups.create', array('name'=>$group_name));
	}
	
    return $result;
}

// Retrieves the information about the private group
function getGroupData($request, $group_id) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'GET', 'groups.info?roomId=' . $group_id, array());
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'GET', 'groups.info?roomId=' . $group_id, array());
	}
	
    return $result;
}

// Changes the name of the private group
function renameGroup($request, $group_id, $group_new_name) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'groups.rename', array('roomId'=>$group_id, 'name'=>$group_new_name));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'groups.rename', array('roomId'=>$group_id, 'name'=>$group_new_name));
	}
	
    return $result;
}

// Removes the private group from the user's list of groups
function closeGroup($request, $group_id) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'groups.close', array('roomId'=>$group_id));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'groups.close', array('roomId'=>$group_id));
	}
	
    return $result;
}

// Removes a user from the private group
function kickUserGroup($request, $user_id, $group_id) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'groups.kick', array('roomId'=>$group_id, 'userId'=>$user_id));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'groups.kick', array('roomId'=>$group_id, 'userId'=>$user_id));
	}
	
    return $result;
}


// USER
// **************
// Creare an user
function createUser($request, $email, $name, $password, $username, $verified) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'users.create', array('email'=>$email, 'name'=>$name, 'password'=>$password, 'username'=>$username, 'verified'=>$verified));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'users.create', array('email'=>$email, 'name'=>$name, 'password'=>$password, 'username'=>$username, 'verified'=>$verified));
	}
	
    return $result;
}

// Create an user token
function createTokenUser($request, $user_id) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'users.createToken', array('userId'=>$user_id));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'users.createToken', array('userId'=>$user_id));
	}
	
    return $result;
}

// Delete an user
function deleteUser($request, $user_id) {
    $url = config('settings.rocket_chat_url');
    $result = getAPIdata($request, $url, 'POST', 'users.delete', array('userId'=>$user_id));
	
	if($result->success!=TRUE) {
		$token = requestToken();
		$result = getAPIdata($request, $url, 'POST', 'users.delete', array('userId'=>$user_id));
	}
	
    return $result;
}



// Funzioni di Supporto
function getAPIdata($request, $url, $type, $route, $input) {
    $connection = getConnectionToAPIs($request, $url);

    $client = $connection['client'];

	if($type=="GET") {
		$response = $client->request($type, $route, ['exceptions' => false]);
	} else if($type=="POST") {
		$response = $client->request($type, $route, 
			['json' => $input, 'exceptions' => false]
		);
	}
	
    $json = $response->getBody();
    $responseData = json_decode($json);

    return $responseData;
}

function getConnectionToAPIs($request, $url) {
	$auth_string = File::get(config_path().'/'.config('settings.auth_rocket_chat_file'));
	
    if ($auth_string=="" or $auth_string==null) {
		$auth_string = requestToken();
	}
	
	$auth_string_sudd = explode(",", $auth_string);
	
    $result['client'] = new GuzzleHttp\Client([
        'base_uri' => $url,
        'headers' => [
            'X-Auth-Token' => $auth_string_sudd[0],
			'X-User-Id' => $auth_string_sudd[1]
        ]
    ]);
	
    return $result;
}

function requestToken() {
	$client = new GuzzleHttp\Client(['base_uri' => config('settings.rocket_chat_url')]);
	$response = $client->request('POST', 'login', [
		'form_params' => [ 'username' => config('settings.rocket_chat_username'), 'password' => config('settings.rocket_chat_psw'), 'exceptions' => false ]
	]);
	$json = json_decode($response->getBody());
	
	$auth_string = $json->data->authToken.",".$json->data->userId;
	File::put(config_path().'/'.config('settings.auth_rocket_chat_file'), $auth_string);
	
	return $auth_string;
}

function clearString($string) {
	$string = str_replace(" ", "", $string);
	
	return $string;
}

// Validate Token Api
function validateToken($token) {
	$client = new GuzzleHttp\Client([
        'base_uri' => config('settings.oauth2'),
        'headers' => [
            'Authorization' => 'Bearer '.$token
        ]
    ]);
	
    if ($token!="" and $token!=null) {
		$response = $client->request('GET', 'validate_token', ['exceptions' => false]);
        $json = json_decode($response->getBody());
		
		if($json=="ACK") {
			return true;
		}
    }
	
	return false;
}

// Definizione array output Api
function apiResult($data, $message) {
	if (is_string($message)) {
		$array = array("data" => $data, "message" => $message);
		return $array;
	}
}
