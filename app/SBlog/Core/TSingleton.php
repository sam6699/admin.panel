<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 15.09.2019
 * Time: 13:48
 */

namespace App\SBlog\Core;


trait TSingleton
{
    private static $instanse;

    public static function getInstance(){
        if (self::$instanse===null){
            self::$instanse = new self();
        }

        return self::$instanse;
    }


}