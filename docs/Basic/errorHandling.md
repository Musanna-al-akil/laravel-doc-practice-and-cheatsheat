# 13. Error Handling

### 1. Reporting exceptions
#### Setup Sentry
1. install sentry/sentry-laravel
```
composer require sentry/sentry-laravel
```
2. Add sentry in [Exceptions/Handler.php](../../app/Exceptions/Handler.php).
```php
public function register(): void
{
    $this->reportable(function (Throwable $e) {
        Integration::captureUnhandledException($e);
    });
}
```
3. Publish the config with `dsn` value.
```
php artisan sentry:publish --dsn=___PUBLIC_DSN___
```

### 2. Global Log Context
You can add additional contextual data by defining a `context` method on `Exception/Handler`. This data will available in every exception's log message.
```php
protected function context():array
{
    return array_merge(parent::context(),[
        'foo'   => 'bar',
    ]);
}
```

### 3. Exception Log Context
You can also add above `context` method in custom exceptions. And log a useful data.

### 4. Exception Log Levels
Ref -> [Exceptions/invalidOrderException](../../app/Exceptions/InvalidOrderException.php). exp: 13.4

```php
protected $levels = [
    PDOException::class => LogLevel::CRITICAL,
];
```

### 5. Ignoring Exceptions By Type
```php
protected $dontReport = [
    InvalidOrderException::class,
];
```

### 6. Reportable & Renderable Exceptions
See the Doc.

### 7. HTTP Exceptions
```php
abort(404);
```

### 5. Custom HTTP Error Pages
```php
<h2>{{ $exception->getMessage() }}</h2>
```
publish default error pages
```
php artisan vendor:publish --tag=laravel-errors
```
You can also define fallback error page for a given series of http status codes.
To accomplish this, define a 4xx.blade.php template and a 5xx.blade.php template in your application's resources/views/errors directory.