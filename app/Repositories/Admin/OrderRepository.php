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

    public function getOneOrder($id){
        $order = $this->startConditions()::withTrashed()
            ->select('orders.*','users.name',
                \DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->where('orders.id',$id)
            ->join('users','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->groupBy('orders.id')
            ->toBase()
            ->limit(1)
            ->first();

        return $order;


    }

    public function getAllProductsId($id){
        $orders = \DB::table('order_products')
            ->where('order_id',$id)
            ->get();

        return $orders;



    }

    public function changeStatusOrder($id){
        $item = $this->getId($id);
        if (!$item)
            abort(404);

        $item->status = !empty($_GET['status'])?'1':'0';

        $result = $item->update();

        return $result;
    }


    public function changeStatusOnDelete($id){
        $st = $this->getId($id);
        if (!$st)
            abort(404);
        $st->status = '2';
        $result = $st->update();

        return $result;



    }

    public function saveOrderComment($id){
        $item = $this->getId($id);

        if (!$item)
            abort(404);

        $item->note= isset($_POST['comment'])?$_POST['comment']:null;
        $result =$item->update();
        return $result;
    }

}