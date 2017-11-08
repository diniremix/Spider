<?php

include_once ('../spider.php');

$req = new Spider("https://httpbin.org/xml", "GET");

$req->setHeader("xml");

$req->send();

header('Content-type: application/xml');

// function to convert an array to XML using SimpleXML
// https://stackoverflow.com/questions/17428323/convert-multidimensional-array-into-xml
function array_to_xml($array, &$xml) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml->addChild("$key");
                array_to_xml($value, $subnode);
            } else {
                array_to_xml($value, $xml);
            }
        } else {
            $xml->addChild("$key","$value");
        }
    }
}

if ($req->hasError()){
	$badResponse = array(
		'getStatusCode' => $req->getStatusCode(),
		'message' => $req->getErrorMessage(),
		'body' => $req->getBody(),
		'getRequest' => $req->getRequest()
	);

	$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><badResponse></badResponse>");
	$node = $xml->addChild('request');

	// function call to convert array to xml
	array_to_xml($badResponse, $node);
	echo $xml->asXML();
}else{
	$resp = $req->getBody('xml');
	echo $resp;
}

