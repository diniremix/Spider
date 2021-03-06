<?php

class Spider {
	private $url = null;
	private $method = 'GET';
	private $body = null;
	private $headers = Array();
	private $allow_redirect = true;
	private $max_redirs = 10;
	private $timeout = 30;
	private $ssl_verify_peer = false;
	private $response_request = null;
	private $response_body = null;
	private $response_headers = Array();
	private $response_code = null;
	private $response_message = null;
	private $response_error = null;
	private $response_error_number = CURLE_OK;
	private $curl = null;


	public function __construct($url, $method = 'GET') {
		$this->url = $url;
		$this->method = $method;
		$this->curl = curl_init();
	}

	public function getRequest() {
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

	public function body($body=null) {
		$this->body = $body;
	}

	public function hasError() {
		return $this->response_error_number;
	}

	public function getErrorMessage() {
		return $this->response_error;
	}

	public function getBody($type=null) {
		if ($this->response_error_number !== CURLE_OK) {
		  return null;
		}

		switch ($type) {
			case 'default':
			case 'json':
				return json_decode(json_encode($this->response_body), true);
				break;
			case 'xml':
				$xml = simplexml_load_string($this->response_body);
				return $xml->asXML();
				break;
			default:
				return $this->response_body;
				break;
		}
	}

	public function getHeaders() {
		return $this->response_headers;
	}

	public function setHeader($headers='default') {
		switch ($headers) {
			case 'default':
			case 'json':
				$this->headers = array("Content-Type: application/json");
				break;
			case 'xml':
				$this->headers = array("Content-Type: application/xml");
				break;
			case 'x-www-form-urlencoded':
			case 'form-urlencoded':
			case 'form':
				$this->headers = array("Content-Type: application/x-www-form-urlencoded");
				break;
			case 'plain':
			case 'text/plain':
				$this->headers = array("Content-Type: text/plain");
				break;
			default:
				$this->headers = array($headers);
				break;
		}
	}

	public function addHeaders($headers=null) {
		array_push($this->headers, $headers);
	}

	public function auth($user, $passwd, $basic=false) {
		if ($basic==true){
			//gen basic auth
			$pass= 'hash 24 chars here';
			array_push($this->headers, "authorization: Basic ".$pass);
		}else{
			$this->body = json_encode(array('username'=>$user,'password'=>$passwd));
		}
	}

	private function constructRequest() {
		curl_setopt_array($this->curl,
			array(
				CURLOPT_URL => $this->url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => $this->max_redirs,
				CURLOPT_SSL_VERIFYPEER, $this->ssl_verify_peer,
				CURLOPT_TIMEOUT => $this->timeout,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => $this->method,
				CURLOPT_POSTFIELDS => $this->body,
				CURLOPT_HTTPHEADER => $this->headers,
			)
		);
	}

	public function send() {
		$this->constructRequest();
		$this->response_body = curl_exec($this->curl);
		$this->response_request = curl_getinfo($this->curl);
		$this->response_error = curl_error($this->curl);
		$this->response_error_number = curl_errno($this->curl);
		curl_close($this->curl);
	}
}
