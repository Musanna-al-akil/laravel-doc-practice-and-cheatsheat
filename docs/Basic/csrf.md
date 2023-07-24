# 3. CSRF Protection

### 1. Preventing CSRF Requests

```php
    <form method="POST" action="/profile">
        @csrf

        <!-- Equivalent to... -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </form>
```

### 2. Excluding URIs From CSRF Protection

Typically, you should place these kinds of routes outside of the web middleware group that
the App\Providers\RouteServiceProvider applies to all routes in the routes/web.php file.
However, you may also exclude the routes by adding their URIs to the $except property of
the VerifyCsrfToken middleware:

```php
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
        'http://example.com/foo/bar',
        'http://example.com/foo/*',
    ];
}
```

### 3. X-CSRF-TOKEN

```html
<meta name="csrf-token" content="{{ csrf_token() }}" />
```

```js
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
```
