# 11. Session

### 1. Configuration
Session config file is stored at `config/session.php`.
There are total 6 sessio drivers.
1. file
2. cookie
3. database
4. redis
5. dynamodb
6. array

### 2. Driver Prerequisites

##### 1. Database
When using the database session driver you will need to create a session database table. This can be done by 
```
$ php artisan session:table

$ php artisan migrate
```

##### 2. Redis
Before using Redis sessions with Laravel, you will need to either install the `PhpRedis` PHP extension via PECL 
or install the `predis/predis` package (~1.0) via Composer. For more information on configuring Redis, consult
Laravel's Redis documentation.

### 3. Retrieving Data

Ref -> [Http/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 11.3
```php 
$sessionValue = $request->session()->get($key, 'default');

//global session helper
//retieve data
$value = session($key, 'default');
```

### 4. Retrieving All Session Data

Ref -> [Http/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 11.4
```php
$allData = $request->session()->all();
```

### 5. Determining If An Item Exists In The Session
Ref -> [Http/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 11.5
```php
//has method return true when -> Item is present and is not null
if ($request->session()->has('users')) {
    // ...
}

//exists method return true when -> Item is present(if it's null it will return true)
if ($request->session()->exists('users')) {
    // ...
}

//missing method return true when if the item is not present
if ($request->session()->missing('users')) {
    // ...
}
```

### 6. Storing Data
Ref -> [Http/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 11.6
```php
//store data in session
session(['key'=>'value']);
$request->session()->put('key', 'value');

//Pushing To Array Session Values
$request->session()->push($array, $value);

//Retrieving & Deleting An Item
$value = $request->session()->pull('key', 'default');

// Incrementing & Decrementing Session Values
$request->session->increment('count', $incrementBy = 2);
$request->session->decrement('count', $decrementBy = 2);
//
```

### 7. Flash Data
Ref -> [Http/BasicController.php](../app/Http/Controllers/BasicController.php). exp: 11.7
```php
$request->session()->flash('status','This is flash data');
//if you need to persist you flash data several requests, reflash method will do it.
$request->session()->reflash();
//
$request->session()->keep(['username', 'email']);
```

### 8. Deleting Data

```php 
// Forget a single key...
$request->session()->forget('name');
 
// Forget multiple keys...
$request->session()->forget(['name', 'status']);
 
$request->session()->flush();
```

### 9. Regenerating The Session ID

```php
$request->session()->regenerate();

//
$request->session()->invalidate();
```

### 10. Session Blocking

```php
Route::post('/order', function () {
    // ...
})->block($lockSeconds = 10, $waitSeconds = 10)
```