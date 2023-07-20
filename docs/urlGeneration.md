# 10. URL Generation

### 1. Generating URLs
Ref -> [Controllers/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 10.1
```php
url('/post/{$post-id}');
//http://example.com/post/1
```

### 2. Accessing the current Url
Ref -> [Controllers/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 10.2

```php
//get the current url without the query string
url()->current();
//get the current url with the query string
url()->full();
//get the previous url with the query string
url()->previous();
//also accessed via facade
URL::current();
```

### 3. URLs For Named Routes
Ref -> [Controllers/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 10.3
```php
$currentPathWithName = route('userName',['name'=>'musanna','id'=>5,'ping'=>'pong']);
//https://example.com/user/musanna/id/5/?ping=pong
```

### 4. Signed URLs
Ref -> [Controllers/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 10.4
```php
$signUrl = Url::signedRoute('signUrl',['name'=>'musanna','id'=>5,'ping'=>'pong']);
$signUrlWithTemporaryTime = URL::temporarySignedRoute('signUrl',now()->addMinutes(10),['name'=>'musanna','id'=>5,'ping'=>'pong']);
```

### 5. Validating Signed Route Requests
Ref -> [web/Route.php](../routes/web.php). exp: 10.4
```php
//sign Url validation with middleware
Route::post('/unsubscribe/{user}', [$class,$method])->name('unsubscribe')->middleware('signed');
//validate with hasValidSignature
  if (! $request->hasValidSignature()) {
        abort(401);
    }
//validate while skipping some parameter
if (! $request->hasValidSignatureWhileIgnoring(['page', 'order'])) {
    abort(401);
}
```
### 6.Responding To Invalid Signed Routes
When someone visits a signed URL that has expired, they will receive a generic error page for the 403 HTTP status code.
However, you can customize this behavior by defining a custom "renderable" closure for the InvalidSignatureException
exception in your exception handler. This closure should return an HTTP response:
```php
public function register(): void
{
    $this->renderable(function (InvalidSignatureException $e) {
        return response()->view('error.link-expired', [], 403);
    });
}
```

### 7. Default Values
To set a default value for url generation, we can register a `middleware` with following line:
```php
URL::defaults(['locale' => $request->user()->locale]);
            //nameOfParam => value
```
You need to priority this middleware to take effect before the laravel own 
`\Illuminate\Routing\Middleware\SubstituteBindings::class` class.