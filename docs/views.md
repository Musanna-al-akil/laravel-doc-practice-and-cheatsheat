# 7. Views

### 1. Creating & Rendering Views & pass data 
Ref -> [Controller/BasicController](../app/Http/Controllers/BasicController.php). exp: 7.1
```php
    //create view with facade
    return View::make('viewPractice',[$varName=> $varValue]);
    //create view with helper funtion
    return view('viewPractice',['name'=>'musanna']);
    // 2
    return view('viewPractice')->with($varName,$varValue)->with(..);
    //verify if view exists
    if(View::exists($viewName)){
        //do something
    }
```

### 2. Sharing Data With All Views
Ref -> [Provider/AppServiceProvider](../app/Providers/AppServiceProvider.php). exp: 7.2
To share data globally you can register `share` method of `View` in any service provider `boot` method.
```php
   public function boot(): void
    {
        View::share('key', 'value');
    }
```

### 3. View Composers
View composers are callbacks or class methods that are called when a view is rendered. If you have data that 
you want to be bound to a view each time that view is rendered, a view composer can help you organize that 
logic into a single location.
To create a composer first you have to create a composer class in `app/View/Composers` and define `composer`
method. In this method define what data you want to share .
Ref -> [Composers/MsgComposer](../app/View/Composers/MsgComposer.php). exp: 7.3
```php
 public function compose(View $view): void
    {
        $view->with('count', $this->users->count());
    }
```
After that add this composer in a service provider via `View::composer` method. 
Ref -> [Provider/ViewServiceProvider](../app/Providers/ViewServiceProvider.php). exp: 7.3
```php
View::composer($ViewFileName, composerDefineClass);
//wild card define 
View::composer('*', composerDefineClass);
```

### 4. View Creators
View `creators` are very similar to view composers; however, they are executed immediately after the view is instantiated instead of waiting until the view is about to render.
```php
View::creator('profile', ProfileCreator::class);
```

### 5. Optimizing Views

```
$ php artisan view:cache
```