<?php

use App\Enums\Category;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\Testcontroller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//1. basic router with closure
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello',function(){
    return 'ola! how are you??';
});

//2. route with method
Route::get('/route-with-method',[BasicController::class,'routeWithMethod']);

//3. available router methods 1. get, 2. post, 3.put, 4. patch, 5. delete, 6. options

//4. route define with match and any

Route::match(['post','get'], '/match-route',[BasicController::class,'routeWithMatch']);
Route::any('/route-any',function(){
        return 'this url will match with any route methods';
});

//6. Redirect route and permanent redirect route

Route::redirect('/ovinondon','/hello','302');
Route::permanentRedirect('/ola','hello');

//7. View Routes

Route::view('/welcome','welcome',['name' => 'musanna']);

//9. parameters and depenency injection and optional parameters

Route::get('/user/{name}/id/{id}', function(Request $request, string $name, int $id ){
    return 'name : ' . $name . ' - ' . $id;  
});

Route::get('/name/{name?}',function(string $name = 'musanna'){
    return $name;
});

//10. regular expression constraints

Route::get('/post/{id}/{slug}',function(int $id, string $slug){
    return $id . ' - ' . $slug;
})->where(['id'=>'[0-9]+', 'slug'=>'[A-Za-z]+']);
//we can also use helper methods. whereNumber($parameterName), whereAlpha(),whereAlphpaNumeric(),
//whereUuid(), whereUlid(), whereIn($paramName, [values]);

//13. Named routes

Route::get('/post' , function(){return 'this is a name route';})->name('post');

// 16. route group
    //middleware
Route::middleware(['guest'])->group(function(){
    Route::get('/route-with-group-middleware',function(){ return 'route with group middleware';});
    // other routes
});

    //route prefix
    Route::prefix('admin')->group(function () {
        // route...
    });

    //route name prefix
    Route::name('admin.')->group(function () {
        //route
    });
// 17. Implicit Binding

    Route::get('/user/{user}', function (User $user){
        return $user->email;
    });

    //we can also pull soft deleted data by chaining withTrashed() method

//18. scoped binding and customize missing model

//by default if there are two and more paramenter nested laravel will use scopedBinding(); 
Route::get('/user/{user}/post/{post}',function(User $user, $post){

})->withoutScopedBindings()->missing(function(){
    return Redirect::route('/');
});

//19. Implicit Enum Binding (PHP8.1)

Route::get('/enum/{category}',function(Category $category){
    return $category->value;
})->middleware('throttle:ratelimitbytwo');

//23. current route 
Route::get('/current-route', function(){
    $route = Route::current();
    $routeName = Route::currentRouteName();
    $action = Route::currentRouteAction();

    return $route->uri . ' - ' . $routeName . ' - ' ;
})->name('route');