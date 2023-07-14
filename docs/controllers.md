# Controllers

### 1. create controller

```
$ php artisan make:controller UserController
```

### 2. Single Action Controllers

Referance -> [Controllers/SingleActionController](../app/Http/Controllers/SingleActionController.php). exp: 2
If a controller action is particularly complex, you might find it convenient to dedicate an 
entire controller class to that single action. To accomplish this, you may define a single 
`__invoke` method within the controller:

```php
class ProvisionServer extends Controller
{
    public function __invoke()
    {
        // ...
    }
}
```
```php 
Route::post('/server', ProvisionServer::class);
```

### 3. Controller Middleware
There are three way to define middleware in a route.

1. assign `middleware` method in routes.

2. using `middleware` method in controller constructor. Ref -> [SingleActionController](../app/Http/Controllers/SingleActionController.php). exp: 3
```php
 public function __construct()
    {
        $this->middleware('auth');
    }
```

3. Controllers also allow you to register middleware using a closure. 
This provides a convenient way to define an inline middleware for a single 
controller without defining an entire middleware class:

```php
$this->middleware(function (Request $request, Closure $next) {
    return $next($request);
});
```

### 4. Resource Controllers
Ref -> [Controllers/PhotoController](../app/Http/Controllers/PhotoController.php). exp: 4

Create resource controller
```
$ php artisan make:controller PhotoController --resource
```

Add Class in route
```php
Route::resource('photos',PhotoController::class);
```

We can also add `withTrashed` method in route where soft delete define in model.

### 5. Partial Resource Routes
When declaring a resource route, you may specify a subset of actions the controller
should handle instead of the full set of default actions:

```php 
Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
]);
 
Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
```

### 6.API Resource Routes

Add routes
```php
Route::apiResource('photos', PhotoController::class);
```

Create api resource
```
$ php artisan make:controller PhotoController --api
```

### 7. Nested Resources
Sometimes you may need to define routes to a nested resource. For example, a photo resource may have multiple comments that may be attached to the photo. To nest the resource controllers, you may use "dot" notation in your route declaration:
```php
Route::resource('photos.comments', PhotoCommentController::class);
```

This route will register a nested resource that may be accessed with URIs like the following:
```
/photos/{photo}/comments/{comment}
```
##### 1. shallow nested resource
We can also use `shallow` method in route for shallow nested resource.

##### 2. Naming Resource Routes
We can explicit define resource route name.
```php
Route::resource('photos', PhotoController::class)->names([
    'create' => 'photos.build'
]);
```

##### 3. Naming Resource Route Parameters
We can explicit define resource route parameters name.

```php
Route::resource('photos',PhotoController::class)->parameters([
    'users'=>'admin_user'
])
```

### 8. Supplementing Resource Controllers
If you need to add additional routes to a resource controller beyond the default 
set of resource routes, you should define those routes before your call to the 
Route::resource method.
```php
Route::get('/photos/popular', [PhotoController::class, 'popular']);
Route::resource('photos', PhotoController::class);
```

### 9. Dependency Injection & Controllers
We can inject class in controller instance `__construct`.
We can also inject class in method.