<?php

function getPagesById($request, $lang, $storesPages) {
    $url = config('urls.portal');
    return getAPIdata($request, $url, 'POST', 'get/stores/pages/list', array('lang'=>$lang, 'storesPages'=>$storesPages));
}

function getStoresByLocation($request, $lang, $lat, $lng, $rad) {
    $url = config('urls.portal');
    return getAPIdata($request, $url, 'GET', $lang . '/stores/' . $lat . '/' . $lng . '/' . $rad . '/0/0');
}

function printTest() {
	echo "ciao";
}

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
	
	if($response->getStatusCode()==401) {
		$token = requestToken();
		getAPIdata($request, $url, $type, $route, $input);
	}
	
    $json = $response->getBody();
    $responseData = json_decode($json);

    $result['data'] = $responseData->data;
    $result['token'] = $connection['token'];

    return $result;
}

function getConnectionToAPIs($request, $url) {
	$token = File::get(config_path().'/'.config('statics.filename_access_token'));
	
    if ($token=="" or $token==null) {
		$token = requestToken();
	}
	
	$result['token'] = $token;
    $result['client'] = new GuzzleHttp\Client([
        'base_uri' => $url,
        'headers' => [
            'Authorization' => $token
        ]
    ]);
	
    return $result;
}