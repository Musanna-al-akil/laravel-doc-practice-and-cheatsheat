# 14. Logging

### 1. Config
Ref -> [config/logging.php](../../config/logging.php).
All config about logging located in this config file. `stack`channel is the default logging channel.

### 2. Setup slack channel
1. Create a slack workstation.
2. Create a slack channel And add webwook app in it.
3. Copy paste the webwook api url `LOG_SLACK_WEBHOOK_URL` in laravel `env` file.
4. Add `slack` channel in in `stack` config.

### 3.Logging Deprecation Warnings
PHP, Laravel, and other libraries often notify their users that some of their features have been deprecated and will be removed in a future version. If you would like to log these deprecation warnings, you may specify your preferred deprecations log channel in your application's config/logging.php configuration file:
```php
'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'deprecations'),
'channels' => [
    'deprecations' => [
        'driver' => 'single',
        'path' => storage_path('logs/php-deprecation-warnings.log'),
    ],
],
```

### 4. Building Log Stacks
Ref -> [config/logging.php](../../config/logging.php).
the `stack` driver allows you to combine multiple channels into a single log channel for convenience.
```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['syslog', 'slack'],
    ],
    //..//
]
```

### 5. Log Levels and messages
Ref [Controllers/PhotoController](../../app/Http/Controllers/PhotoController.php).
There are total 8 log levels: `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency`. Debug is the lowest level of log and emergency is the highest level of log.
```php
Log::alert('this is an alert log');
```

### 6. Contextual Information
```php
Log::info('User {id} failed to login.', ['id' => $user->id]);

//
$requestId = (string) Str::uuid();
Log::withContext([
    'request-id' => $requestId
]);

// share inforamtion across all logging channels.
Log::shareContext([
    'invocation-id' => (string) Str::uuid(),
]);
```

### 7. Writing To Specific Channels
```php
Log::channel('slack')->info('something happended');

//stack
Log::stack(['single','stack'])->info('something happended');
```

### 8. On-Demand Channels
```php
Log::build([
    'driver'=>'single',
    'path'  => storage_path('logs/custome.log')
])->info('something');
//you can also add on demand channels in stack by storing on demand channel in variable.
```

### 9. Monolog Channel Customization
See the Doc