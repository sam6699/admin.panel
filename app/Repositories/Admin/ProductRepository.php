<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 17.09.2019
 * Time: 22:12
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Product;

class ProductRepository extends CoreRepository
{


    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    protected function getModelClass()
    {
        return Product::class;

    }

    public function getAllProducts($perpage){
        $get = $this->startConditions()
            ->orderBY('id','desc')
            ->limit($perpage)
            ->paginate($perpage);

        return $get;

    }
}