# 2. Middleware

### 1. Creating and defining middleware
Reference [SecretTokenValidation.php](../app/Http/Middlewares/SecretTokenValidation.php) exp: 1

```
$ php artisan make:middleware SecretTokenValidation
```
This is a before middleware. It will effect before the request handle
```php 
public function handle(Request $request, Closure $next): Response
    {
        if($request->input('token') !== 'top-secret-token'){
            return redirect('home');
        }
        return $next($request);
    }
```

### 2. after middleware
Reference [AfterMiddleware.php](../app/Http/Middlewares/AfterMiddleware.php) exp: 2

```php
public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        //perform action

        return $response;
    }
```

### 3. Registering Middleware

##### 1.Global Middleware
We can register a middleware in the  `$middleware` or `$middlewareGroup` property of [app/Http/Kernel.php](../app/Http/Kernel.php).exp: 3
We can also register alias in this file. We can also create our own middleware group in `$middlewareGroup`.

##### 2.Assigning Middleware To Routes

Referece [routes/web.php](../routes/web.php)-> exp:3.2

```php
Route::get($uri, $callback)->middleware(middlewareClass Or 'middlewarealias');
```
###### 3. Excluding Middleware
If we include a middleware in a group we may need to exclude some of the middleware from a route.
We can use it then.

```php
Route::get($uri, $callback)->withoutMiddleware(middlewareClass Or 'middlewarealias');
```
*** The withoutMiddleware method can only remove route middleware and 
    does not apply to global middleware.

### 4. Sorting Middleware
Reference-> [app/Http/Kernel.php](../app/Http/Kernel.php) exp: 4

By default it's not exist in kernel. We may copy it below if we need.
```php
    protected $middlewarePriority = [
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
        \Illuminate\Contracts\Session\Middleware\AuthenticatesSessions::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
```

### 5. Middleware Parameters

Additional middleware parameters will be passed to the middleware after the $next argument:

Middleware parameters may be specified when defining the route by separating the middleware 
name and parameters with a :. Multiple parameters should be delimited by commas:

```php
Route::put('/post/{id}', function (string $id) {
    // ...
})->middleware('role:editor');
```

### 6. Terminable Middleware
Sometimes a middleware may need to do some work after the HTTP response has been sent to the browser. 
If you define a terminate method on your middleware and your web server is using FastCGI, 
the terminate method will automatically be called after the response is sent to the browser:

```php
 public function terminate(Request $request, Response $response): void
    {
        // ...
    }
```

When calling the terminate method on your middleware, Laravel will resolve a fresh instance of 
the middleware from the service container. If you would like to use the same middleware instance 
when the handle and terminate methods are called, register the middleware with the container using 
the container's singleton method. Typically this should be done in the register method of your 
AppServiceProvider:

```php
public function register(): void
{
    $this->app->singleton(TerminatingMiddleware::class);
}
```