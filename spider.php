<?php

class Spider {
	public $url = null;
	public $method = 'GET';
	public $body = null;
	public $headers = Array();
	public $allow_redirect = true;

	private $response_request = null;
	private $response_body = null;
	private $response_headers = Array();
	private $response_code = null;
	private $response_message = null;
	private $response_error = null;
	public $port = null;
	public $curl = null;

	public function __construct($url, $method = 'GET') {
		$this->url = $url;
		$this->method = $method;
		$this->curl = curl_init();
	}

	public function response_request() {
		return $this->response_request;
	}
	public function getHeaderLine($line=null) {
		// see http://php.net/manual/es/function.curl-getinfo.php
		// for more info
		if($line){
			return $this->response_request[$line];
		}
		return $this->response_request['content_type'];
	}

	public function getStatusCode() {
		return (int) $this->response_request['http_code'];
	}

	public function getBody($type=null) {
		switch ($type) {
			case 'json':
				return json_decode(json_encode($this->response_body), true);
				break;
			default:
				return $this->response_body;
				break;
		}
	}

	public function getHeaders() {
		return $this->response_headers;
	}

	public function setHeaders($headers) {
		if($headers==='default'){
			$this->headers = array("content-type: application/json");
		}else{
			$this->headers = array($headers);
		}
	}

	public function auth($user, $passwd, $basic=false) {
		if ($basic==true){
			//gen basic auth
			$pass= 'hash 24 chars here';
			array_push($this->headers, "authorization: Basic ".$pass);
		}else{
			$this->body = array('username'=>$user,'password'=>$passwd);
		}
	}

	private function constructRequest() {
		curl_setopt_array($this->curl, array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $this->method,
			CURLOPT_POSTFIELDS => $this->body,
			CURLOPT_HTTPHEADER => $this->headers,
		));
	}
	public function send() {
		$this->constructRequest();
		$this->response_body = curl_exec($this->curl);
		$this->response_request = curl_getinfo($this->curl);
		$this->response_error = curl_error($this->curl);
		curl_close($this->curl);
	}

}
