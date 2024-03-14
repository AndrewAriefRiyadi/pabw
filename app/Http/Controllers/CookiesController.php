<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CookiesController extends Controller
{
    //
    public function setCookie()
    {
        if (!request()->hasCookie('cookie_consent')) {
            return response(view('welcomw'))->withCookie('cookie_consent', Str::uuid(), 1);
        }
        return view('welcome');
    }

    public function getCookie()
    {
        return request()->cookie('cookie_consent');
    }

    public function deleteCookie()
    {
        return response('deleted')->cookie('cookie_consent', null, -1);
    }
}
