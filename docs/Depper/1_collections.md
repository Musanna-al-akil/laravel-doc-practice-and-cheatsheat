# 1.Collections

### 1.Introduction and create
Ref -> [Controllers/AdvancedController](../../app/Http/Controllers/AdvancedController.php). Exp 1.1
The Illuminate\Support\Collection class provides a fluent, convenient wrapper for working with arrays of data. By using collection you can take advantage of collections method.
```php
//create collection
$collection = collect([1,2,3]);
$collection = new Collection([1,2,3]);
```

### 2. Extending Collections
You can add additional methods to Collection class at runtime.
```php
Collection::macro('increamentByFive', function($value){
    return $this->map(function($item){
        return $item + 5;
    })
})
//macro with arguments
 
Collection::macro('toLocale', function (string $locale) {
    return $this->map(function (string $value) use ($locale) {
        return Lang::get($value, [], $locale);
    });
});
 $collection->toLocale('es')
```

### 3. Available Methods(frequent use)

##### 1. all()
Get all data as an array.
```php
collect([1,2,3])->all();
```
#### 2. avg()
Get the average value
```php 
collect([1,2,3])->avg();
```

#### 3. chunk()
Get a chunk of data as array
```php
collect([1,2,3])->chunk(2);
```
#### 4. chunkWhile()
Get a chunk of data as array base on logic
```php
collect([1,2,3])->chunkWhile(function ($item, $key) {
    return $key % 2 === 0;
});
```
