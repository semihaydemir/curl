# PHP Curl Class

This library provides an object-oriented wrapper of the PHP cURL extension.

If you have questions or problems with installation or usage [create an Issue](https://github.com/semihaydemir/curl/issues).

## Installation

In order to install this library via composer run the following command in the console:

```sh
composer require assistant/curl
```



## Usage examples

```php
$curl = new Assistant/Curl();
$curl->get('http://www.example.com/');
```

```php
$curl = new Assistant/Curl();
$curl->request('get','http://www.example.com/');
```

```php
$curl = new Assistant/Curl();
$curl->request('post','http://www.example.com/','params');
```

```php
$curl = new Assistant/Curl();
$curl->get('http://www.example.com/search', array(
    'q' => 'keyword',
));
```

```php
$curl = new Assistant/Curl();
$curl->post('http://www.example.com/login/', array(
    'username' => 'myusername',
    'password' => 'mypassword',
));
```