<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 15.09.2019
 * Time: 13:53
 */

namespace App\SBlog\Core;


class Registry
{
    use TSingleton;
    protected static $properties=[];

    public function setProperty($name,$value){
        self::$properties[$name]=$value;

    }

    public function getProperty($name){

        if (isset(self::$properties[$name]))
            return self::$properties[$name];

        return null;
    }

    public function getAllProperties(){

        return self::$properties;

    }


}