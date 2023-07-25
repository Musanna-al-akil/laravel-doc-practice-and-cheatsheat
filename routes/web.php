<?php

use App\Enums\Category;
use App\Http\Controllers\AdvancedController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SingleActionController;
use App\Http\Controllers\Testcontroller;
use App\Http\Middleware\AfterMiddleware;
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
//1.1. basic router with closure && 6.1 response string & array
Route::get('/', function () {
    return view('welcome');
});

//2.(4) single action controller && 13.1 sentry test
Route::get('/debug-sentry',SingleActionController::class)->name('debug');

//1.2. route with method
Route::get('/route-with-method',[BasicController::class,'routeWithMethod']);

//1.3. available router methods 1. get, 2. post, 3.put, 4. patch, 5. delete, 6. options

//1.4. route define with match and any

Route::match(['post','get'], '/match-route',[BasicController::class,'routeWithMatch']);
Route::any('/route-any',function(){
        return 'this url will match with any route methods';
});

//1.6. Redirect route and permanent redirect route

Route::redirect('/ovinondon','/hello','302');
Route::permanentRedirect('/ola','hello');

//1.7. View Routes

Route::view('/welcome','welcome',['name' => 'musanna']);

//1.9. parameters and depenency injection and optional parameters

Route::get('/user/{name}/id/{id}', function(Request $request, string $name, int $id ){
    return 'name : ' . $name . ' - ' . $id;  
})->name('userName');

// 10.5 sign url validation with middleware
Route::get('/sign/user/{name}/id/{id}', function(Request $request, string $name, int $id ){
    return 'name : ' . $name . ' - ' . $id . ' and this is a sign url';  
})->name('signUrl')->middleware('signed');

Route::get('/name/{name?}',function(string $name = 'musanna'){
    return $name;
});

//1.10. regular expression constraints

Route::get('/post/{id}/{slug}',function(int $id, string $slug){
    return $id . ' - ' . $slug;
})->where(['id'=>'[0-9]+', 'slug'=>'[A-Za-z]+']);
//we can also use helper methods. whereNumber($parameterName), whereAlpha(),whereAlphpaNumeric(),
//whereUuid(), whereUlid(), whereIn($paramName, [values]);

//1.13. Named routes

Route::get('/post' , function(){return 'this is a name route';})->name('post');

// 1.16. route group
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
// 1.17. Implicit Binding

    Route::get('/user/{user}', function (User $user){
        return $user->email;
    });

    //we can also pull soft deleted data by chaining withTrashed() method

//1.18. scoped binding and customize missing model

//by default if there are two and more paramenter nested laravel will use scopedBinding(); 
Route::get('/user/{user}/post/{post}',function(User $user, $post){

})->withoutScopedBindings()->missing(function(){
    return Redirect::route('/');
});

//1.19. Implicit Enum Binding (PHP8.1)

Route::get('/enum/{category}',function(Category $category){
    return $category->value;
})->middleware('throttle:ratelimitbytwo');

//1.23. current route 
Route::get('/current-route', function(){
    $route = Route::current();
    $routeName = Route::currentRouteName();
    $action = Route::currentRouteAction();

    return $route->uri . ' - ' . $routeName . ' - ' ;
})->name('route');

// 3.2 register middleware in route web 
Route::get('/middleware',function(){
    return 'this route is bind with afterMiddleware';
})->middleware(AfterMiddleware::class);

// Resource and validation
Route::resource('photos',PhotoController::class);

//5.1 accessing request
Route::get('/requestpractice',[BasicController::class,'requestPractice'])->name('requestPractic');

//6 && 6.3 Cache Control Middleware
Route::get('/responsepractice',[BasicController::class,'responsePractice'])->name('responsePractic')->middleware('cache.headers:public;max_age=2628000;etag');

//7 
Route::get('view-and-blade',[BasicController::class,'viewAndBlade'])->name('viewAndBlade');


//Digging Deeper
//Collections
Route::get('/collection',[AdvancedController::class,'collection'])->name('collection');