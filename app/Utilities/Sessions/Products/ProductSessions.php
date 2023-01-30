<?php

namespace App\Utilities\Sessions\Products;

class ProductSessions
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

    public static function storeSession( $sessionName , $data)
    {
        session()->put("$sessionName" , [$data]);
    }

    public static function addToSession( $sessionName , $data)
    {
        session()->push( $sessionName , $data);
    }
}
