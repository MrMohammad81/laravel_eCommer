<?php

namespace App\Services\Sessions;

use App\Exceptions\SessionNotFound;
use function session;

class SessionService
{
    public static function findSession($sessionName)
    {
        if (session()->has("$sessionName"))
            return true;
        return false;
    }

    public static function checkSession( $data , $sessionName)
    {
        if (in_array( $data , session()->get("$sessionName")))
            return true;
        return false;
    }

    public static function storeSession( $sessionName , array $data)
    {
        session()->put("$sessionName" , $data);
    }

    public static function addToSession( $sessionName , $data)
    {
        session()->push( $sessionName , $data);
    }

    public static function getSession($sessionName)
    {
        return session()->get("$sessionName");
    }

    public static function pullSession($sessionName , $key)
    {
        session()->pull("$sessionName." . $key);
    }

    public static function forgetSession($sessionName)
    {
        session()->forget("$sessionName");
    }
}
