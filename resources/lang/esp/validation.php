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

    'accepted' => 'El :attribute debe ser aceptado.',
    'accepted_if' => 'El :attribute debe aceptarse cuando :other es :value.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute sólo debe contener letras.',
    'alpha_dash' => 'El :attribute solo debe contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute sólo debe contener letras y números.',
    'array' => 'El :attribute debe ser un arreglo.',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El :attribute debe estar entre :min y :max caracteres.',
        'array' => 'El :attribute debe estar entre :min y :max elementos.',
    ],
    'boolean' => 'El :attribute debe ser verdadero o falso.',
    'confirmed' => 'El :attribute confirmación no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'declined' => 'El :attribute debe ser rechazado.',
    'declined_if' => 'El :attribute debe rechazarse cuando :other es :value.',
    'different' => 'El :attribute y :other debe ser diferente.',
    'digits' => 'El :attribute debe ser de :digits dígitos.',
    'digits_between' => 'El :attribute debe estar entre :min y :max dígitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'El :attribute el campo tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes: :values.',
    'enum' => 'El :attribute seleccionado no es válido.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'file' => 'El :attribute debe ser mayor que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor que :value caracteres.',
        'array' => 'El :attribute debe ser mayor que :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser mayor o igual que :value.',
        'file' => 'El :attribute debe ser mayor o igual que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual que :value caracteres.',
        'array' => 'El :attribute debe tener :value elementos o mas.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.',
    'in_array' => 'El :attribute no existe en :other.',
    'integer' => 'El :attribute debe ser un entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'mac_address' => 'El :attribute debe ser una dirección MAC válida.',
    'json' => 'El :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor que :value.',
        'file' => 'El :attribute debe ser menor que :value kilobytes.',
        'string' => 'El :attribute debe ser menor que :value caracteres.',
        'array' => 'El :attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor o igual que :value.',
        'file' => 'El :attribute debe ser menor o igual que :value kilobytes.',
        'string' => 'El :attribute debe ser menor o igual que :value caracteres.',
        'array' => 'El :attribute no debe tener más de :value elementos.',
    ],
    'max' => [
        'numeric' => 'El :attribute no debe ser mayor que :max.',
        'file' => 'El :attribute no debe ser mayor que :max kilobytes.',
        'string' => 'El :attribute no debe ser mayor que :max caracteres.',
        'array' => 'El :attribute no debe tener más de :max elementos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El :attribute al menos debe ser :min.',
        'file' => 'El :attribute al menos debe ser :min kilobytes.',
        'string' => 'El :attribute al menos debe ser :min caracteres.',
        'array' => 'El :attribute debe tener al menos :min elementos.',
    ],
    'multiple_of' => 'El :attribute debe ser múltiplo de :value.',
    'not_in' => 'El :attribute seleccionado no es valido',
    'not_regex' => 'El :attribute el formato no es válido.',
    'numeric' => 'El :attribute Tiene que ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El :attribute debe estar presente.',
    'prohibited' => 'El :attribute el campo esta prohibido.',
    'prohibited_if' => 'El :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El :attribute está prohibido a menos que :other es en :values.',
    'prohibits' => 'El :attribute prohíbe :other de estar presente.',
    'regex' => 'El :attribute el formato no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El :attribute es obligatorio a no ser que :other es en :values.',
    'required_with' => 'El :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El :attribute es obligatorio cuando :values están presentes',
    'required_without' => 'El :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El :attribute es obligatorio cuando none of :values están presentes.',
    'same' => 'El :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El :attribute debe ser de :size.',
        'file' => 'El :attribute debe ser de :size kilobytes.',
        'string' => 'El :attribute debe ser de:size caracteres.',
        'array' => 'El :attribute debe contener :size elementos.',
    ],
    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes: :values.',
    'string' => 'El :attribute debe ser string.',
    'timezone' => 'El :attribute debe ser una area horaria válida.',
    'unique' => 'El :attribute ya se ha tomado.',
    'uploaded' => 'El :attribute no se pudo cargar',
    'url' => 'El :attribute debe ser una URL válida.',
    'uuid' => 'El :attribute debe ser una UUID válida.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'nombre_cat'=> 'Nombre de la categoría'
    ],

];
