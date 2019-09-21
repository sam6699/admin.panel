<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 17.09.2019
 * Time: 21:34
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Model;

class MainRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public static function getOrderCount(){
        $count = \DB::table('orders')
            ->where('status','0')
            ->get()
            ->count();

        return $count;

    }

    public static function getUsersCount(){
        $count = \DB::table('users')
            ->get()
            ->count();

        return $count;


    }


    public static function getProductsCount(){
        $count = \DB::table('products')
            ->get()
            ->count();

        return $count;

    }


    public static function getCategoriesCount(){
        $count = \DB::table('categories')
            ->get()
            ->count();

        return $count;


    }



}