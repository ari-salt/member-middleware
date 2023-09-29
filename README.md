# member-middleware
A Laravel/Lumen middleware to get the app user ID based on the CIAM ID.

## Installation
```
$ composer require ari-salt/member-middleware
```

## Usage
Register middlewares to the routes.
```php
use AriSALT\AuthMiddleware\AuthOfflineMiddleware;
use AriSALT\MemberMiddleware\MemberMiddleware;

$app->routeMiddleware([
    'auth_offline' => AuthOfflineMiddleware::class,
    'member' => MemberMiddleware::class
]);
```
Apply them to the routes.
```php
$router->get('/test', [
    'middleware' => [
        'auth_offline:memberForgeRock,VERIFY_TOKEN,forge-rock',
        'member:memberForgeRock,users,id,forgerockID,userID,VERIFY_TOKEN,forge-rock'
    ],
    'uses' => 'ExampleController@index'
]);
```
Then, you can use it on your handlers.
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index(Request $request)
    {
        var_dump($request->get('userID'));
    }
}

```