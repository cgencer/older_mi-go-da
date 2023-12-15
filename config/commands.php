<?php

return [

    /**
     * The model you want use as the Role model.
     */
    'role' => 'Spatie\Permission\Models\Role',

    /**
     * The model you want use as the User model.
     */
    'user' => 'App\Models\User',

    /**
     * The attributes your User model uses.
     *
     * Specify the attributes that you will be asked when using the 'user:create' command.
     * You can list them in an array or in a key-value pair in the case you want to use your
     * own question for the attribute.
     */
    'user_attributes' => [
        'name' => 'Name?',
        'email' => 'Email',
        'password' => 'Password'
    ],

    /**
     * The attributes that are sensitive such as a password.
     *
     * The input is hidden for these fields and stored encrypted.
     */
    'user_attributes_sensitive' => ['password'],

];