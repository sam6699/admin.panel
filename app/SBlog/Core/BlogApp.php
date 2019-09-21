<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 15.09.2019
 * Time: 13:59
 */

namespace App\SBlog\Core;


class BlogApp
{
    public static $app;

    public static function get_instance(){
        self::$app = Registry::getInstance();
        self::getParams();
        return self::$app;
    }

    protected static function getParams(){
        $params = require CONF.'/params.php';

        if (!empty($params)){
            foreach ($params as $k => $v){
                self::$app->setProperty($k,$v);


            }


        }


    }

}