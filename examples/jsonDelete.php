<?php

include_once ('../spider.php');

$req = new Spider("http://httpbin.org/delete", "DELETE");

$req->setHeader("default");

$req->send();

header('Content-type: application/json');

if ($req->hasError()){
	echo json_encode(array(
		'getStatusCode' => $req->getStatusCode(),
		'message' => $req->getErrorMessage(),
		'body' => $req->getBody(),
		'getRequest' => $req->getRequest()
	));
}else{
	echo json_encode(array(
		'getStatusCode' => $req->getStatusCode(),
		'body' => $req->getBody(),
		'getHeaderLine' => $req->getHeaderLine(),
		'getHeaderLine primary_ip ' => $req->getHeaderLine('primary_ip'),
		'getHeaders' => $req->getHeaders(),
		'getErrorMessage' => $req->getErrorMessage(),
		'getRequest' => $req->getRequest()
	));
}
