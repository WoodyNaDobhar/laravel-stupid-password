<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Config
    |--------------------------------------------------------------------------
    |
    | Various variables
    |
    */

    //max pw length
    'max' => env('PASSWORD_MAX', '40'),

    //local words to exclude, such as the site name, domain, etc
    'environmentals' => env('PASSWORD_ENVIRONMENTALS', []),

    //options
    'options' => env('PASSWORD_OPTIONS', []),

];
