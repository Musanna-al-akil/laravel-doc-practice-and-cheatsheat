# 12. Validation

### 1. Define validate with default Request validate method
For less complex validation and quickstart, You may use `$request->validate`.
```php
 $validatedData = $request->validate([
    'title' => ['required', 'unique:posts', 'max:255'],
    //To stop after the first validation failure You may use `bail`
    'body' => 'bail|required|unique:posts|max:255',
    //nested field data
    'author.name' => 'required',
]);
```

### 2. Displaying The Validation Errors
Ref -> [components/forms/input](../resources/views/components/forms/input.blade.php). exp:12.2
```html
<!-- access all errors-->
@foreach ($errors->all() as $error)
                <li>{{ $error }}</li> 
@endforeach

<!-- access single errors-->
 @error('email')
    {{ $message }}
@enderror
```
### 3. Customizing The Error Messages
You can customize error messages from `lan/en/validation.php` file. you may instruct Laravel to
create it using the lang:publish Artisan command.

### 4. Repopulating Forms ( old() )
Ref -> [components/forms/input](../resources/views/components/forms/input.blade.php).
```html
input type="text" name="title" value="{{ old('title') }}">
```

### 5. Validation Error Response Format
```json
{
    "message": "The team name must be a string. (and 4 more errors)",
    "errors": {
        "team_name": [
            "The team name must be a string.",
            "The team name must be at least 1 characters."
        ],
        "authorization.role": [
            "The selected authorization.role is invalid."
        ],
        "users.0.email": [
            "The users.0.email field is required."
        ],
        "users.2.email": [
            "The users.2.email must be a valid email address."
        ]
    }
}
```

## 6. Form Request Validation

### 6.1. Creating Form Requests
```
$ php artisan make:request StorePhotoRequest
```
This command will create a `StorePhotoRequest` in `app/Http/Requests` with `authorize` and `rules` methods. You can define the rules in `rules` method. The `rules` method return a array.

Ref -> [StorePhotoRequest.php](../app/Http/Requests/StorePhotoRequest.php). exp: 12.6.1
```php
public function rules(): array
{
    return [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ];
}
```

### 6.2 Performing Additional Validation
Ref -> [StorePhotoRequest.php](../app/Http/Requests/StorePhotoRequest.php). exp: 12.6.2
You can also define additional validation rules in return array with invokable classes.
```php
public function after(): array
{
    return [
        function (Validator $validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add(
                    'field',
                    'Something is wrong with this field!'
                );
            }
        },
        //class with __invoke method can also added here
        new ValidateUserStatus,
    ];
}
```

### 6.3 Stopping On The First Validation Failure
If we want to stop validation check after one validation failure we can use `$stopOnFirestFailure`
property. This will return only one validation failure.
```php
protected $stopOnFirstFailure = true;
```

### 6.4 Customizing The Redirect Location
```php
protected $redirect = '/dashboard';
```

### 6.5 Authorizing Form Requests
Ref -> [StorePhotoRequest.php](../app/Http/Requests/StorePhotoRequest.php). exp: 12.6.5
You can also define the authorization rules in `authorize` method. The `authorize` method return 
a boolean value. If you don't need authorization check, you can return `true`.
```php
public function authorize(): bool
{
    $comment = Comment::find($this->route('comment'));
 
    return $comment && $this->user()->can('update', $comment);
}
```

### 6.6 Customizing The Error Messages
Ref -> [StorePhotoRequest.php](../app/Http/Requests/StorePhotoRequest.php). exp: 12.6.6

```php
public function messages(): array
{
    return [
        'title.required' => 'A title is required',
    ];
}
```

### 6.7 Customizing The Validation Attributes
```php
public function attributes(): array
{
    return [
        'email' => 'email address',
    ];
}
```

### 6.8 Preparing Input For Validation
```php
//this will apply before the validation
protected function prepareForValidation(): void
{
    $this->merge([
        'slug' => Str::slug($this->slug),
    ]);
}
//this will apply after the validation
protected function passedValidation(): void
{
    $this->replace(['name' => 'Taylor']);
}
```

## 7. Manually Creating Validators
Ref -> [Controllers/PhotoController](../app/Http/Controllers/PhotoController.php) `update` method. exp:12.7

```php
    $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:64',
        ],$messages =[
            'required' => 'This :attribute is required.',
        ],$attributes = [
            'name' => 'Name',
        ]);
 
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();
 
        // Retrieve a portion of the validated input...
        $validated = $validator->safe()->only(['name', 'email']);
        $validated = $validator->safe()->except(['name', 'email']);
        //
        //other code
```

### 7.2 Automatic Redirection
```php
//it will automatic redirect with validation error
Validator::make($request->all(),[
    'name' => 'required'
])->validate();
```

### 7.3 Named Error Bags
If you have multiple forms on a single page, you may wish to name the MessageBag containing 
the validation errors, allowing you to retrieve the error messages for a specific form.
To achieve this, pass a name as the second argument to withErrors:
```php
return redirect('register')->withErrors($validator, 'login');
```
You may then access the named MessageBag instance from the `$errors` variable:
```php
{{ $errors->login->first('email') }}
```

### 7.4 Performing Additional Validation
Same as like Request Validation with `after` method. but this is done with `Validator->after($closure)`. This is also accept Invoke classes.
```php
$validator->after(function ($validator) {
    if ($this->somethingElseIsInvalid()) {
        $validator->errors()->add(
            'field', 'Something is wrong with this field!'
        );
    }
});
```

### 8. Working With Validated Input
Ref -> [Controllers/PhotoController](../app/Http/Controllers/PhotoController.php) 
```php
//retrive validated input
$validated = $request->validated();
 
$validated = $validator->validated();
//retrive only selected input
$validated = $request->safe()->only(['name', 'email']);
 
$validated = $request->safe()->except(['name', 'email']);
 //retrive all
$validated = $request->safe()->all();
//get the data
$email = $validated['email'];
//merge data
$validated = $request->safe()->merge(['name' => 'Taylor Otwell']);

```

### 9. Working With Error Messages

```php
//retrive first error msg
$errors = $validator->errors()->first('email');

//get all error msgs for a field
foreach ($errors->get('email') as $message) {
    // ...
}
//get error for array
$errors->get('attachments.*');
//get all errors 
$errors->all();
//check a error 
if ($errors->has('email')) {
    // ...
}
```

### 10. Specifying Values In Language Files
```php
Validator::make($request->all(), [
    'credit_card_number' => 'required_if:payment_type,cc'
]);
```

Instead of displaying cc as the payment type value, you may specify a more user-friendly 
value representation in your lang/xx/validation.php language file by defining a values array:
```php
'values' => [
    'payment_type' => [
        'cc' => 'credit card'
    ],
],
```

### 11. Available Validation Rules
See laravel Doc.

### 12. Conditionally Adding Rules
```php
 
$validator = Validator::make($data, [
    'has_appointment' => 'required|boolean',
    'appointment_date' => 'exclude_if:has_appointment,false|required|date',
    'doctor_name' => 'exclude_if:has_appointment,false|required|string',
]);
```

### 13. Validating When Present
In some situations, you may wish to run validation checks against a field only if that field is present in the data being validated. To quickly accomplish this, add the sometimes rule to your rule list:
```php
$v = Validator::make($data, [
    'email' => 'sometimes|required|email',
]);
```

### 14. Complex Conditional Validation
See laravel Doc.
### 15.Validating Passwords
```php
Password::min(8)
    ->letters()
    ->mixedCase()
    ->numbers()
    ->symbols()
    ->uncompromised()
```