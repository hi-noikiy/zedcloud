<?php

namespace Modules\Album\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiPhotoPost extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            '_album_id' => 'required|size:16',
            'url'       => 'required|max:128',
            'like'      => 'numeric',
        ];
    }

    /**
     * Custom attribute name
     *
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public function attributes() {
        return trans('album::validation.attributes');
    }

    /**
     * Custom error message
     *
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public function messages() {
        return trans('album::validation');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
}
