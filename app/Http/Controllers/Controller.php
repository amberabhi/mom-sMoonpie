<?php

namespace App\Http\Controllers;

use stdClass;

abstract class Controller
{
    function isAuth(){
        return auth('customer')->check();
    }

    function authCustomer(){
        return auth('customer')->check() == true ? auth('customer')->user() : new stdClass;
    }
}
