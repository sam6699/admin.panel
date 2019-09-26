<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 23.09.2019
 * Time: 20:00
 */

namespace App\Repositories\Admin;


use App\Models\Admin\User;
use App\Repositories\CoreRepository;

class UserRepository extends CoreRepository
{


    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();


    }

    public function getAllUsers($per_page){
            $users = $this->startConditions()
                ->join('user_roles','user_roles.user_id','=','users.id')
                ->join('roles','roles.id','=','user_roles.role_id')
                ->select('users.id','users.name','users.email','roles.name as role')
                ->toBase()
                ->paginate($per_page);
            return $users;
    }


    protected function getModelClass()
    {
           return User::class;
    }

    public function getUserOrders($id,$per_page){
        $orders = $this->startConditions()->withTrashed()
            ->join('orders','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->select('orders.id','orders.user_id','orders.status','orders.created_at','orders.updated_at',
                'orders.currency',\DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->where('user_id',$id)
            ->groupBy('orders.id')
            ->orderBy('orders.status')
            ->orderBy('orders.id')
            ->paginate($per_page);

        return $orders;

    }

    public function getUserRole($id){
        $role = $this->startConditions()
            ->find($id)
            ->roles()
            ->first();


        return $role;
    }

    public function getCountOrdersPerPag($id){
        $count = \DB::table('orders')
            ->where('user_id',$id)
            ->count();

        return $count;

    }

    public function getCountOrders($id,$per_page){
        $count = \DB::table('orders')
            ->where('user_id',$id)
            ->limit($per_page)
            ->get();

            return $count;

    }

}