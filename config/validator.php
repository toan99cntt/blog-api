<?php

return [
    'username' => '/^[a-zA-Z0-9_-]+$/',
    'email' => '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z0-9]{1,}$/',
    'time_format' => 'date_format:H:i',
    'password' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
    'check_space' => '/^\S*$/u',
    'number' => '/^[0-9]*$/',
    'number_float' => '/^[\.0-9]*$/',
];
