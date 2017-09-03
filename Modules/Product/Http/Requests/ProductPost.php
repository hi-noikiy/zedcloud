<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPost extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [

            'cover'        => 'required|image|max:2048',
            'name'         => 'required|max:128',
            'price'        => 'required|numeric|max:2147483647',
        ];
    }

    /**
     * Custom attribute name
     *
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public function attributes() {
        return trans('product::validation.attributes');
    }

    /**
     * Custom error message
     *
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public function messages() {
        return trans('product::validation');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
