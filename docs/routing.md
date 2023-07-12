# this doc about laravel route doc

### 1. basic route with closure
Referece [routes/web.php](../routes/web.php)-> exp:1

```php
    Route::get('/hello',function(){
        return 'ola!';
    });
```
### 2. route with method
Referece [routes/web.php](../routes/web.php)-> exp:2

```php
    Route::get('/route-with-method',[BasicController::class,'routewiht method']);
```

### 3. available router methods
Referece [routes/web.php](../routes/web.php)-> exp:3

```php
    Route::get($uri, $callback);
    Route::post($uri, $callback);
    Route::put($uri, $callback);
    Route::patch($uri, $callback);
    Route::delete($uri, $callback);
    Route::options($uri, $callback);
```

### 4. route with match and any method
Referece [routes/web.php](../routes/web.php)-> exp:4 

```php
    Route::match(['get','put'], $uri, $callback);
    Route::any($uri, $callback);
```

### 5. Dependency Injection and csrf protection

- **laravel service container automatically resolved and inject dependency in router callback function.**
- **post, put, patch, delete routes should include a csrf token field. otherwise it will rejected.**

### 6. Redirect route and Permanent redirect route
Referece [routes/web.php](../routes/web.php)-> exp:6

```php
    Route::redirect($uri, $destinationUri, $statusCode = 302,301);
    Route::permanentRedirect($uri, $destinationUri);
```

### 7. View routes
Referece [routes/web.php](../routes/web.php)-> exp:7

```php
    Route::view($uri, $viewPage, array $data);
```

### 8. route list

`php artisan route:list` -> to see all avilable route
`php artisan route:list -v` -> to see all avilable route with middleware
`php artisan route:list --path=api` -> avilable route with path
`php artisan route:list --except-vendor` -> hide route that are defined by 3rd party package
`php artisan route:list --only-vendor` -> show route that are defined by 3rd party package

### 9. parameters and dependency injection And optinal parameters
Referece [routes/web.php](../routes/web.php)-> exp:9
dependency will define first and rest will be url parameters.


```php
    Route::get('/user/{name}', function(Request $request, string $id){
        return 'user' . $id;
    });

    Route::get('/name/{name?}',function(string $name = 'musanna'){
    return $name;
});
```

### 10. Regular expression constraints and helper methods
Referece [routes/web.php](../routes/web.php)-> exp:10


```php
    Route::get('/post/{id}/{slug}',function(int $id, string $slug){
        return $id . ' - ' . $slug;
    })->where(['id'=>'[0-9]+', 'slug'=>'[A-Za-z]+']);
```

```php
Route::get('/user/{id}/{name}', function (string $id, string $name) {
    // ...
})->whereNumber('id')->whereAlpha('name');
 
Route::get('/user/{name}', function (string $name) {
    // ...
})->whereAlphaNumeric('name');
 
Route::get('/user/{id}', function (string $id) {
    // ...
})->whereUuid('id');
 
Route::get('/user/{id}', function (string $id) {
    //
})->whereUlid('id');
 
Route::get('/category/{category}', function (string $category) {
    // ...
})->whereIn('category', ['movie', 'song', 'painting']);
```

### 12. global constraints

we can also define expression in `boot` method of `App\Providers\RouteServiceProvider` class:
```php
Route::pattern('id','[0-9]+');
```

### 13. Named routes
Referece [routes/web.php](../routes/web.php)-> exp:13

```php
    Route::get($uri,$callback)->name(string $routeName);
```

### 14. Generating URLs To Named Routes

```php
    //in array first we have to define url param and rest will be url query.
    $url = route('profile', ['id' => 1, 'photos' => 'yes']);
    // /user/1/profile?photos=yes

    // Generating Redirects...
    return redirect()->route('profile');
 
    return to_route('profile');
```

### 15. current route

we can check current route with `$request->route()->named($routeNamed)`.

### 16. Route group
Referece [routes/web.php](../routes/web.php)-> exp:16

```php
    Route::middleware([$middlewareName])->group(function(){
        // other routes
    });
    //route prefix
    Route::prefix('admin')->group(function () {
        // route...
    });

    //route name prefix
    Route::name('admin.')->group(function () {
        //route
    });

    //we can use multiple prefix option in same group

    Route::name('admin.')->prefix('admin')
    ->middleware([$middlewareName])->group(function(){
        //route...
    })
```

### 17. Implicit Binding
Referece [routes/web.php](../routes/web.php)-> exp:17

```php
  Route::get('/user/{user}', function (User $user){
        return $user->email;
    });

    //we can also pull soft deleted data by chaining withTrashed() method
    Route::get('/user/{user}', function (User $user){
        return $user->email;
    })->withTrashed();

    // we can also customize the key if it is not `id`
    Route::get('/posts/{post:slug}', function (Post $post) {
    return $post;
});
```

### 18. Custom Keys & Scoping and Customizing Missing Model Behavior
Referece [routes/web.php](../routes/web.php)-> exp:18

```php
//by default if there are two and more paramenter nested laravel will use scopedBinding(); 
Route::get('/user/{user}/post/{post}',function(User $user, Post $post){

})->withoutScopedBindings()->missing(function(){
    return Redirect::route('home');
});
```

### 19. Implicit Enum Binding (PHP8.1)
Referece [routes/web.php](../routes/web.php)-> exp:19

```php
Route::get('/enum/{category}',function(Category $category){
    return $category->value;
});
```

we can also explicit binding in `boot` method in `RouteServiceProvider`.

### 20.Fallback Routes
fallback route will be the last route of web.php. we can use it for custom 404 handling. and we can also bind middleware with it.
```php 
Route::fallback(function () {
    // ...
});
```

### 21. Rate Limiting
Referece [app/Providers/RouteServiceProvider.php](../app/Providers/RouteServiceProvider.php)-> exp:21

```php
RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        // we can also add custom response if ratelimiter overflow by response method
```

multiple ratelimit are difine in array.

#### Attaching Rate Limiters To Routes

```php
Route::middleware(['throttle:ratelimitbytwo'])->group(function () {
    Route::post('/audio', function () {
        // ...
    });
});
```
for performance we can use redis base throttle by adding 
`'throttle' => \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class, `

### 22.Form Method Spoofing

HTML forms do not support PUT, PATCH, or DELETE actions. So, when defining PUT, PATCH, or DELETE 
routes that are called from an HTML form, you will need to add a hidden _method field to the form. 
```html
<form action="/example" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
```
For convenience, you may use the @method Blade directive to generate the _method input field:
```html
<form action="/example" method="POST">
    @method('PUT')
    @csrf
</form>
```

### 23.Accessing The Current Route
Referece [routes/web.php](../routes/web.php)-> exp:23
```php
    $route = Route::current();
    $routeName = Route::currentRouteName();
    $action = Route::currentRouteAction();
```