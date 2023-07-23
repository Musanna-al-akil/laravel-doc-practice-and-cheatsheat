# 8. Blade Templates

### 1. Displaying Data
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.1

```html
<p> {{$variable}} </p>
//current time with sec
{{ time()}}
```

### 2. Displaying Unescaped Data
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.2
```html
{!! '<h1>hello</h1>' !!}
```
### 3. Blade & JavaScript Frameworks
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.3
```html
 @{{ name }}
 //output: {{ name }}

 @@if
 //output: @if
```

### 4. Rendering json
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.4

```html
{{json_encode($array)}}

//inside script
<script>
var app = {{Js:from($array)}};
<script>
```

### 5. The @verbatim Directive
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.5

If you are displaying JavaScript variables in a large portion of your template, you may 
wrap the HTML in the `@verbatim` directive so that you do not have to prefix each Blade 
echo statement with an `@` symbol:
```html
@verbatim
    <div class="container">
        Hello, {{ name }}.
    </div>
@endverbatim
```

### 6. Blade Directives
Ref -> [views/viewAndBlade](../resources/views/viewAndBlade.blade.php). exp: 8.5

```html
    @if(condition)
    //something
    @elseif(condition)
    //something
    @else
    //something
    @endif

    //
    @unless (Auth::check())
        You are not signed in.
    @endunless

    //
    @isset($records)
        // $records is defined and is not null...
    @endisset
    
    @empty($records)
        // $records is "empty"...
    @endempty
```

#### authentication directives
```html
    @auth('admin')
        // this is admin
    @endauth
    @guest('admin')
        //this is guest
    @endguest
```

#### Environment Directives

```html
    @env(['staging', 'production'])
        // The application is running in "staging" or "production"...
    @endenv
    @production
    // Production specific content...
    @endproduction
```

#### Switch Statements
```html
@switch($i)
    @case(1)
        First case...
        @break

    @default
        Default case...
@endswitch
```

#### Loops

```html
    @for ($i = 0; $i < 10; $i++)
        The current value is {{ $i }}
    @endfor
    
    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif
    
        <li>{{ $user->name }}</li>
    
        @if ($user->number == 5)
            @break
        @endif
    @endforeach
    
    @forelse ($users as $user)
        <li>{{ $user->name }}</li>
    @empty
        <p>No users</p>
    @endforelse
    
    @while (true)
        <p>I'm looping forever.</p>
    @endwhile
```

You can access some variable in side foreach.see The Loop Variable varibale in doc

#### Conditional Classes & Styles
```html
@php 
$isActive = false;
@endphp
<span @class([
'p-4',
'bg-red' => $isActive
])> hello </span>

<span @style([
    'background-color: red',
    'font-weight: bold' => $isActive,
])></span>
```

#### Additional Attributes
```html
<input @checked(//login)>
<option @selected(//logic)>
<button @disabled(//logic)>
<input @required(//logic)>
```

#### Including Subviews
```html
@include('view.name', [$dataName => $dataValue])
@includeIf('view.name', [$dataName => $dataValue])
```

## 7. Components

### 7.1 Creating Component
Ref -> [Components/inputField.php](../app/View/Components/inputField.php). exp:8.7.1
```
//create class based components
$ php artisan make:component formField

//create anonymous components
$ php artisan make:component forms.input --view
```

### 7.2 Manually Registering Package Components
if you are building a package that utilizes Blade components, you will need to manually register
your component class and its HTML tag alias. You should typically register your components in 
the `boot` method of your package's service provider:
```php
public function boot(): void
{
    Blade::component('package-alert', Alert::class);

    //you may use the `componentNamespace` method to autoload component classes by convention
    Blade::componentNamespace('Nightshade\\Views\\Components', 'nightshade');
}
```
### 7.3 Rendering Components
Ref -> [photos/create.blade.php](../resources/views/photos/create.blade.php). exp: 8.7.3
```html
<x-form-input/>

<!-- nested component-->
<x-inputs.button/>
```
If you would like to conditionally render your component, you may define a `shouldRender` method on
your component class. If the `shouldRender` method returns false the component will not be rendered

### 7.4 Passing Data To Components
Ref -> [photos/create.blade.php](../resources/views/photos/create.blade.php). exp: 8.7.3
```html
<x-forms.input type="text" :label="$label">
```
Ref -> [Components/inputField.php](../app/View/Components/inputField.php). exp:8.7.4
```php
 public function __construct(
        public string $type,
        public string $message,
    ) {}
```
Ref -> [components/forms/input](../resources/views/components/forms/input.blade.php). exp: 8.7.4
```html
<div>
    <label>{{$label}} : </label>
    <input type="{{$type}}">
</div>
```
Component constructor arguments should be specified using `camelCase`, while `kebab-case` should 
be used when referencing the argument names in your HTML attributes. 

### 7.5 Escaping Attribute Rendering
 you may use a double colon (::) prefix to inform Blade that the attribute is not a PHP expression.
```html
<x-button ::class="{danger: isDeleteing}"></x-button
```

### 7.6 Hiding Attributes / Methods
To hide public attributes/methods from being exposed as variables to component template you may add them to `$except` array property.

```php
protected $except = ['type'];
```

### 7.7 Component Attributes
Additional html attributes(such as class) that are not define component can be access via
`{{$attributes}}`.
Ref -> [photos/create.blade.php](../resources/views/photos/create.blade.php). exp: 8.7.7
```html
<div {{ $attributes }}>
    <!-- Component content -->
</div>
```

### 7.8 Default / Merged Attributes
Ref -> [components/forms/input](../resources/views/components/forms/input.blade.php). exp: 8.7.8

```html
<div {{ $attributes->merge(['class' => 'alert alert-'.$type]) }}>
    {{ $message }}
</div>

<!-- conditionallly merge-->
<div {{ $attributes->class(['p-4', 'bg-red' => $hasError]) }}>
    {{ $message }}
</div>

<!-- chain merge method to  -->
<button {{ $attributes->class(['p-4'])->merge(['type' => 'button']) }}>
    {{ $slot }}
</button>
```

### 7.9 check a attribute is present on the componet or not

```html
@if ($attributes->has('class'))
    <div>Class attribute is present</div>
@endif
```
Get a specific attribute's value:
```html
{{ $attributes->get('class') }}
```

### 7.10 Slots
Ref -> [components/forms/input](../resources/views/components/forms/input.blade.php).

```html 
<div  {{ $attributes->merge(['class'=>'font-bold']) }} >
    <!-- 8.7.4 passing data -->
    {{$prependSlot}}
    <label>{{$label}} : </label>
    <input type="{{$type}}">
    {{$slot}}
</div>
```
Ref -> [photos/create.blade.php](../resources/views/photos/create.blade.php).
```html
<x-forms.input type="text" label="Name" class="text-medium text-green-800" data="nothing">
    <x-slot:title>pingpong</x-slot:title>
</x-forms.input>
```

### 7.11 Slot Attributes
```html
<x-card class="shadow-sm">
    <x-slot:heading class="font-bold">
        Heading
    </x-slot>
 
    Content
 
    <x-slot:footer class="text-sm">
        Footer
    </x-slot>
</x-card>
```
```html
@props([
    'heading',
    'footer',
])
 
<div {{ $attributes->class(['border']) }}>
    <h1 {{ $heading->attributes->class(['text-lg']) }}>
        {{ $heading }}
    </h1>
 
    {{ $slot }}
 
    <footer {{ $footer->attributes->class(['text-gray-700']) }}>
        {{ $footer }}
    </footer>
</div>
```

### 8. Layouts Using Template Inheritance
Ref -> [layouts/guestLayout](../resources/views/layouts/guestLayout.blade.php).
```html
<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show
 
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
```
Ref -> [photos/create.blade.php](../resources/views/photos/create.blade.php).
```html
@extends('layouts.app')
 
@section('title', 'Page Title')
 
@section('sidebar')
    @parent
 
    <p>This is appended to the master sidebar.</p>
@endsection
 
@section('content')
    <p>This is my body content.</p>
@endsection
```

### 9. Method Field
Since HTML forms can't make `PUT`, `PATCH`, or `DELETE` requests, you will need to add a hidden _method
field to spoof these HTTP verbs. The `@method` Blade directive can create this field for you:
```html
<form action="/foo/bar" method="POST">
    @method('PUT')
    ...
</form>
```

### 10. Validation Errors
Ref -> [layouts/guestLayout](../resources/views/layouts/guestLayout.blade.php).
```html
<label for="title">Post Title</label>
 
<input id="title"
    type="text"
    class="@error('title') is-invalid @enderror">
 
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```

### 11. Stacks
Pages:
```html
@push('scripts')
    <script src="/example.js"></script>
@endpush
```
Layout
```html
<head>
    <!-- Head Contents -->
 
    @stack('scripts')
</head>
```

### 12. Service Injection
```html
@inject('metrics', 'App\Services\MetricsService')
 
<div>
    Monthly Revenue: {{ $metrics->monthlyRevenue() }}.
</div>
```

### 13. Extending Blade (directive)
Follow Laravel Doc.

### 14. Custom If Statements
Ref [Providers/AppServiceProvider.php](../app/Providers/AppServiceProvider.php)
```php
public function boot(): void
{
    Blade::if('disk', function (string $value) {
        return config('filesystems.default') === $value;
    });
}
```
In templates:
```html
@disk('local')
    <!-- The application is using the local disk... -->
@elsedisk('s3')
    <!-- The application is using the s3 disk... -->
@enddisk
```