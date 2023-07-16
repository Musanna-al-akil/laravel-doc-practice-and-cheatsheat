# 5. HTTP Requests

### 1. Accessing The Request
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.1

```php
public function index(Request $request): RedirectResponse
    {
        //
    }
```

### 2. Retrieving The Request Path
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.2

```php
$path = $request->path();
```

### 3. Inspecting The Request Path / Route
The is method allows you to verify that the incoming request path matches a given pattern. 
You may use the * character as a wildcard when utilizing this method:
```php
if ($request->is('admin/*')) {
    // ...
}
```

Using the routeIs method, you may determine if the incoming request has matched a named route:
```php
if ($request->routeIs('admin.*')) {
    // ...
}
```

### 4. Retrieving The Request Full URL
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.4

```php
$request->url();
//
$request->fullUrl();
```

If you would like to append query string data to the current URL, you may call the 
`fullUrlWithQuery` method. This method merges the given array of query string variables 
with the current query string:
```php
$request->fullUrlWithQuery(['type' => 'phone']);
```

**You can also get full Path with query and without a specific query .

```php
$request->fullUrlWithQuery([]);
$request->fullUrlWithoutQuery(['search']);
```

### 5. Retrieving The Request Host
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.5

```php
$host = $request->host();
$hostWithPort = $request->httpHost();
$hostWithPortAndProtocal = $request->schemeAndHttpHost();
```

### 6. Retrieving The Request Method
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.6

```php
$method =$request->method();
//check method
if ($request->isMethod('post')) {
    // ...
}
```

### 7. Request Headers
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.7
```php
$header= $request->header('X-Header-One');
//check header
$request->hasHeader('X-Header-Name')
// bearerToken
$token = $request->bearerToken();
```

### 8. Request IP Address
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.8
```php
$ip = $request->ip();
```

### 9. Content Negotiation
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.9
```php
$contentTypes = $request->getAcceptableContentTypes();

//check a content type is accepted
if($request->accepts(['text/html','application/json']))
//check expect json or not
if ($request->expectsJson()) {
    // ...
}
```

## Retrieving Input

### 10.Retrieving All Input Data
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.10
```php
$request->all();
$request->collect();
$request->collect('users')->each(function (string $user) {
    // ...
});
```

### 11. Retrieving An Input Value
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.11

```php
$request->input('name');
//get array type input by dot 
$request->input('product.0.name');
```
`input` method without argument will retrieve all the of the input value.

### 12. Retrieving Input From The Query String
While the `input` method retrieves values from the entire request payload (including the query string), 
the `query` method will only retrieve values from the query string:
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.12
```php
$request->query('name');
// retrive all query data
$request->query();
```
### 13. Retrieving JSON Input Values
We can accept json data vai the  `input` method as long as the Content-Type set to `application/json`.

#### Retrieving Boolean Input Values
```php
$archived = $request->boolean('archived');
```

#### Retrieving Date Input Values
```php
// retrieved as carbon instance
$birthday = $request->date('birthday');
```

#### Retrieving Enum Input Values
```php
$status = $request->enum('status', Status::class);
```

#### Retrieving Input Via Dynamic Properties
```php
$name = $request->name;
```

#### Retrieving A Portion Of The Input Data
```php
$input = $request->only(['username', 'password']);
$input = $request->except(['credit_card']);
```

### 14. Determining If Input Is Present
Ref [Controllers/BasiController.php](../app/Http/Controllers/BasiController.php). exp: 5.14

```php
if($request->has(['name','password']))

//check if any of that input available
if($request->hasAny(['name','password']))

//if input available excute the closure
$request->whenHas('name', function (string $input) {
    // The "name" value is present...
}, function () {
    // The "name" value is not present...
});
//check input value is present
if ($request->filled('name')) {
    // ...
}

//check input value is not available
if ($request->missing('name')) {
    // ...
}
 
$request->whenMissing('name', function (array $input) {
    // The "name" value is missing...
}, function () {
    // The "name" value is present...
});
```

### 15. Merging Additional Input

```php
$request->merge(['votes' => 0]);
$request->mergeIfMissing(['votes'=>0]);
```

### 16.Flashing Input To The Session
The flash method on the `Illuminate\Http\Request` class will flash the current input to the session
so that it is available during the user's next request to the application:
```php
$request->flash();
$request->flashOnly(['name']);
$request->flashExcept(['password']);
```


### 16. Flashing Input Then Redirecting

```php
return redirect('form')->withInput();
 
return redirect()->route('user.create')->withInput();
```

### 17.Retrieving Old Input
```php
$username = $request->old('username');
```
```html
<input type="text" name="username" value="{{ old('username') }}">
```

### 18. Retrieving Cookies From Requests
```php
$request->cookie('name');
```

### 19. Retrieving Uploaded Files

```php
$file= $request->file('photo');

//verify a file is successfully uploaded
if ($request->file('photo')->isValid()) {
    // ...
}
```
### 20. File Paths & Extensions

```php
$path = $request->photo->store('images');
//save with file name
$path = $request->photo->storeAs('images', 'filename.jpg');
```

## Configuring Trusted Proxies
details in [laravel Doc](https://laravel.com/docs/10.x/requests).