# Spider
http request easy, using [**curl**](http://php.net/manual/en/book.curl.php)

## Install
Clone this repo

    git clone git://github.com/diniremix/spider.git


Download a stable version from **Spider** [here](https://github.com/diniremix/spider/archive/master.zip)


## how to use

```php
$req = new Spider("https://httpbin.org/get", "GET");
$req->setHeader("default"); // set default "Content-Type: application/json"
$req->send();

//handle response
if ($req->hasError()){
	//do stuff
    echo $req->getBody();
}else{
	//an error ocurred
    echo $req->getErrorMessage();
}
```


### response
```json
{

    "args": { },
    "headers": {
        "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Encoding": "gzip, deflate, br",
        "Accept-Language": "en-US,en;q=0.5",
        "Host": "httpbin.org",
        "Referer": "https://httpbin.org/",
        "User-Agent": "Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"
    },
    "origin": "186.81.109.31",
    "url": "https://httpbin.org/get"

}
```


## Methods

### Public Methods

- **getRequest**: return full response request from [curl](http://php.net/manual/en/book.curl.php)
- **getHeaderLine**: get specific result from response request, return `content_type` by default
- **getStatusCode**: get status code from response using [http_code](http://php.net/manual/en/function.curl-getinfo.php)
- **body**: set the body of the request to send
- **hasError**: get the last error number from [curl_errno](http://php.net/manual/en/function.curl-errno.php)
- **getErrorMessage**: get a string containing the last error for the current session from [curl_error](http://php.net/manual/en/function.curl-error.php)
- **getBody**: return a response body from request if `hasError` it's different from [CURLE_OK](http://php.net/manual/en/curl.constants.php)
- **getHeaders**: `**needs more implementation**`
- **setHeader**: set the headers of the request to send, set `Content-Type: application/json` by default
- **addHeaders**: add extra headers (e.g. Authorization)
- **auth**: set the `authorization: Basic` to body using `user` and `password` fields, if `basic` params is **true**
- **send**: this method perform a [cURL session](http://php.net/manual/en/function.curl-exec.php) and [close](http://php.net/manual/en/function.curl-close.php) when finally

### Private Methods

- **constructRequest**: this method construct a request using multiple options for a [cURL transfer](http://php.net/manual/en/function.curl-setopt-array.php)


## Examples
see [examples folder](examples/)


## license
The full text of the license can be found in the file **LGPL.txt**


## Contact
[Diniremix on GitHub](https://github.com/diniremix)

email: *diniremix [at] gmail [dot] com*
