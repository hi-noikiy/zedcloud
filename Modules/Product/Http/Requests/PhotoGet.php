<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoGet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '_product_id' => 'required|size:16',
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
