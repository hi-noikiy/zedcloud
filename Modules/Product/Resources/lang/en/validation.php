<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'max'      => 'The :attribute may not be greater than :max characters.',
    'min'      => 'The :attribute must be at least :min characters.',
    'required' => 'The :attribute field is required.',
    'size'     => 'The :attribute must be :size characters.',
    'image'    => 'The :attribute must be an image.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        '_category_id' => 'Category',
        'sale_type'    => 'Sale type',
        'name'         => 'Name',
        'cover'        => 'Cover',
        '_album_id'    => 'Album',
        'url'          => 'Url',
        'price'        => 'Price',
        'sales_volume' => 'Sales volume',
    ],

];
