# PHP Assistant/Curl Class

![enter image description here](https://2.bp.blogspot.com/-6c5vC3FcSBM/VjDgQfrOOiI/AAAAAAAAIXE/hq0-TtyXugY/s1600/phpcurl.png)

This library provides an object-oriented wrapper of the PHP cURL extension.

If you have questions or problems with installation or usage [create an Issue](https://github.com/semihaydemir/curl/issues).

## Installation

In order to install this library via composer run the following command in the console:

```sh
composer require assistant/curl
```


## Usage examples

```php
$curl=new Assistant\Curl();
$curl->get('https://httpbin.org/get');
```

```php
$curl=new Assistant\Curl();
$curl->get('https://httpbin.org/get','first_name=Semih&last_name=Aydemir');
```

```php
$curl=new Assistant\Curl();
$curl->post('https://httpbin.org/post');
```

```php
$curl=new Assistant\Curl();
$curl->post('https://httpbin.org/post','first_name=Semih&last_name=Aydemir');
```

```php
$curl=new Assistant\Curl();
$curl->request('get','https://httpbin.org/post','first_name=Semih&last_name=Aydemir');
```

```php
$curl=new Assistant\Curl();
$curl->request('post','https://httpbin.org/post','first_name=Semih&last_name=Aydemir');
```
## Available methods
 - $curl->setLink();
 - $curl->getLink();
 - $curl->setHeader();
 - $curl->getHeader();
 - $curl->setHeaders();
 - $curl->getHeaders();
 - $curl->setUserAgent();
 - $curl->getUserAgent();
 - $curl->setProxy();
 - $curl->getProxy();
 - $curl->setFollowLocation();
 - $curl->getFollowLocation();
 - $curl->setTimeOut();
 - $curl->getTimeOut();
 - $curl->setParams();
 - $curl->getParams();
 - $curl->getResponse();
 - $curl->getErrorMessage();
 - $curl->getErrorNo();
 - $curl->getInfo();
 - $curl->isSuccess();
 - $curl->curl2string();
 - $curl->log();
 - $curl->get();
 - $curl->post();
 - $curl->request();

