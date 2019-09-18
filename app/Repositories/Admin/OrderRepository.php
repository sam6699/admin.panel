<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 17.09.2019
 * Time: 22:13
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Order;

class OrderRepository extends CoreRepository
{


    /**
     * OrderRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();


    }

    protected function getModelClass()
    {
        return Order::class;


    }

    public function getAllOrders($perpage){
        $order = $this->startConditions()::withTrashed()
            ->select('orders.id','orders.user_id','orders.status','orders.created_at',
                'orders.updated_at','orders.currency','users.name',
                \DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->join('users','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->groupBy('orders.id')
            ->orderBy('orders.status')
            ->orderBy('orders.id')
            ->toBase()
            ->paginate($perpage);


        return $order;

    }
}