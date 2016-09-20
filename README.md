# Spider
http request easy, using curl

## Install
Clone this repo

    git clone git://github.com/diniremix/spider.git


Download a stable version from **Spider** [here](https://github.com/diniremix/spider/archive/master.zip)


## how to use
```php
$req = new Spider("https://httpbin.org/get", "GET");
$req->setHeader("default"); // set default "Content-Type: application/json"
$req->send();
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
- **getStatusCode**: return a [http_code](http://php.net/manual/en/function.curl-getinfo.php) from request.
- **getBody**: return a body from request.
- **addHeaders**: add extra headers


## license
The full text of the license can be found in the file **LGPL.txt**


## Contact
[Diniremix on GitHub](https://github.com/diniremix)

email: *diniremix [at] gmail [dot] com*

