<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductRepository;
use Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends AdminBaseController
{
    private $orderRepository;
    private $productRepository;

    /**
     * MainController constructor.
     * @param $orderRepository
     * @param $productRepository
     */
    public function __construct()
    {
        $this->orderRepository = app(OrderRepository::class);
        $this->productRepository = app(ProductRepository::class);
    }


    public function index(){

        $orders = MainRepository::getOrderCount();
        $products = MainRepository::getProductsCount();
        $categories = MainRepository::getCategoriesCount();
        $users = MainRepository::getUsersCount();

        $per_page = 4;

        $last_orders = $this->orderRepository->getAllOrders($per_page);
        $last_products = $this->productRepository->getAllProducts($per_page);

        Meta::title('админ панель');
            return view('blog.admin.main.index',
                compact('orders','products','categories','users','last_orders','last_products'));

    }
}
