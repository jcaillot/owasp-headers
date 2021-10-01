# jcaillot/owasp-headers

### OWASP header middleware for the Laravel framework

> Laravel middleware. Adds OWASP recommended headers to the response

## Prerequisites

> Laravel >= 5.2

## Installation

#### 1. install library

```shell
composer require jcaillot/owasp-headers
```

#### 2. Edit the config file

copy `./vendor/jcaillot/owasp-headers/config/owasp-headers-example.php` to `./config/owasp-headers-php`
in your app config directory:

```shell

    php -r "copy( 'vendor/jcaillot/owasp-headers/config/owasp-headers-example.php', 'config/owasp-headers.php');"

```

Do not hesitate to edit your version of `./config/owasp-headers.php` in order to fine-tune the OWASP recommended
headers. Here is the default list of headers that will be added to the response:

```php
    return [
    
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
    # Prevents the browser from interpreting files as something else than declared by the content type:
    'X-Content-Type-Option' => 'nosniff',
    'Content-Type' => 'text/html; charset=utf-8',
    # Enables the Cross-site scripting (XSS) filter in the browser:
    'X-XSS-Protection' => '1; mode=block',
    # The browser must not display the transmitted content in frames:
    'X-Frame-Options' => 'DENY',
    # No XML policy file( (for Flash or Acrobat) allowed:
    # see https://www.adobe.com/devnet-docs/acrobatetk/tools/AppSec/xdomain.html
    'X-Permitted-Cross-Domain-Policies' => 'none',
    # Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included:
    'Referrer-Policy' => 'same-origin',
    # Content Security Policy (CSP) requires careful tuning
    # see https://csp-evaluator.withgoogle.com
    # example: 'Content-Security-Policy' => 'default-src \'self\'; img-src \'self\'; script-src \'self\'; frame-ancestors \'none\'',
    'Content-Security-Policy' => 'frame-ancestors \'none\'',
    # Selectively enable and disable use of various browser features and APIs
    'Feature-Policy' => 'camera: \'none\'; payment: \'none\'; microphone: \'none\'',
];

```

#### 3. Declare the middleware in Kernel

in `app/Kernel.php`, you can declare the middleware globally. All responses will be affected:

```php
    protected $middleware = [
         ...
         \App\Http\Middleware\OwaspHeaders::class,
         
        ];
```

alternatively, you can declare it as a route middleware and associate it on a route basis:

```php
        protected routeMiddleware = [
             ...
            'owasp.headers' => \App\Http\Middleware\OwaspHeaders::class,
        
        ];
```

And apply it later on (in `routes/web.php`):

```php
    Route::get('/home', function () {
        ...
    })->middleware('owasp.headers');
```

## About OWASP recommender headers

More infos on OWASP recommended headers can be found on the OWASP Secure Headers Project Wiki:

[OWASP](https://wiki.owasp.org/index.php/OWASP_Secure_Headers_Project#tab=Headers)

## License

[MIT](https://choosealicense.com/licenses/mit/)

