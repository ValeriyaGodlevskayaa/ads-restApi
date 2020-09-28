<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    //переопределяем формат ошибки во время валидации
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['error' => $validator->errors(), 'code' => 422], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:1000',
            'price' => 'required|integer',
            'images' => 'array|required|min:1|max:3',
            'images.*' => 'string|min:3',
            'main_image' =>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Required name',
            'description.required' => 'Required description',
            'price.required' => 'Required price',
            'main_image.required' => 'Required main image.',
            'images.required' => 'Required images'
        ];
    }

}
