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

### 7. Components
