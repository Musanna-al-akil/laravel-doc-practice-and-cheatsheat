# 6. HTTP Responses

### 1. Creating Responses

#### 1. Strings & Arrays
Ref [routes/web.php](../routes/web.php). exp 6.1.
```php
Route::get('/',function(){
    return 'hello';
    //return [1,2,3];
})
```

#### 2. Response Objects
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.1.2
```php
return response($string, $statusCode);
```

### 2. Attaching Headers To Responses
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.2

```php
return response($content)->header($headerName, $headerValue)->header($headName2, $headerValue2);
//withHeader
return response($content)->withHeaders([$headerName=> $headerValue,...]);
```

### 3. Cache Control Middleware
Ref [routes/web.php](../routes/web.php). exp 6.3
Laravel includes a cache.headers middleware, which may be used to quickly set the Cache-Control 
header for a group of routes. Directives should be provided using the "snake case" equivalent of 
the corresponding cache-control directive and should be separated by a semicolon. If etag is 
specified in the list of directives, an MD5 hash of the response content will automatically be 
set as the ETag identifier:
```php
Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('/privacy', function () {
        // ...
    });
});
```

### 4. Attaching Cookies To Responses
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.4

```php
return response('Hello World')->cookie(
    'name', 'value', $minutes, $path, $domain, $secure, $httpOnly
);
//cookie with facade
Cookie::queue($name,$value,$minutes);
// global cookie helper function

$cookie = cookie($name, $value, $minutes);
```

#### 2. Expiring Cookies Early
```php
response($content)->withoutCookie($name);
//facade
Cookie::expire($name);
```

### 5. Cookies & Encryption(disable)
Ref [Middleware\EncryptCookie](../app/Http/Middleware/EncryptCookies.php). exp 6.4
You can disable cookie encryption by using $except property of `Ap\Http\Middleware\EncryptCookie`.
```php
protectet $except = [
    'cookie_name',
];
```

### 6. Redirects

Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.6
```php
return redirect()
//back prev url
return back()->withInput();
```

### 7. Redirecting To Named Routes
```php
//redirect to following uri: /profile/{id}
return redirect()->route('profile',['id'=>1]);
```

### 8. Redirecting To Controller Actions

```php
//You have to pass 2nd arg if method req parameter
return redirect()->action([UserController::class, 'profile'], ['id'=>1])
```

### 9. Redirecting To External Domains
```php
return redirect()->away('https://gooogle.com');
```

### 10. Redirecting With Flashed Session Data
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.6

```php
return redirect('dashboard')->with($name, $value);
```
```html
//retrive session value
@if (session($name))
    <div class="alert alert-success">
        {{ session($name) }}
    </div>
@endif
```

### 11. Redirecting With Input
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.6
```php
return redirect()->withInput();
```

### 12. View Responses
Ref [Controllers/BasicController](../app/Http/Controllers/BasicController.php). exp 6.12
```php
return response()->view($bladePath, $data, 200)->header(...);
```
If you don't need status code and header; you can use global view function.

### 13. JSON Responses
```php
return response()->json([
    'name' => 'Abigail',
    'state' => 'CA',
]);
```

### 14. File Downloads
The download method may be used to generate a response that forces the user's browser to download the
file at the given path. The download method accepts a filename as the second argument to the method, 
which will determine the filename that is seen by the user downloading the file. Finally, you may 
pass an array of HTTP headers as the third argument to the method:
```php
return response()->download($pathToFile);
 
return response()->download($pathToFile, $name, $headers);
```

### 15. Streamed Downloads
Sometimes you may wish to turn the string response of a given operation into a downloadable response without 
having to write the contents of the operation to disk. You may use the streamDownload method in this scenario. 
This method accepts a callback, filename, and an optional array of headers as its arguments:
```php
return response()->streamDownload(function () {
    echo GitHub::api('repo')
                ->contents()
                ->readme('laravel', 'laravel')['contents'];
}, 'laravel-readme.md');
```

### 16. File Responses
```php
return response()->file($pathToFile, $headers);
```

### 17. Response Macros
Ref [Providers\AppServiceProvider](../app/Providers/AppServiceProvider.php). exp 6.12

```php
 public function boot(): void
    {
        Response::macro('caps', function (string $value) {
            return Response::make(strtoupper($value));
        });
    }
```
```php
return response()->caps('foo');
```