<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    //12.6.1 rules method
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:64',
            'email'=>'required|email|max:64|unique:photos,email',
            'username'=>'required|string|max:20|unique:photos,username',
            'number' =>'required|numeric|digits:11',
            'age'=>'required|integer|min:18|max:100',
            'show_data'=>'required|boolean',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ];
    }
    //12.6.6 customize the error message
    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
        ];
    }
     //12.6.7 customize the validation attributes
     public function attributes():array
    {
        return [
            'email' => 'Email address',
        ];
    }
    //12.6.2 additional validation
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!true) {
                    $validator->errors()->add(
                        'name',
                        'Something is wrong with this field!'
                    );
                }
            }
        ];
    }
}
