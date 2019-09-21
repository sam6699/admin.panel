<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\AdminOrderSaveRequest;
use App\Models\Admin\Order;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends AdminBaseController
{
    private $orderRepository;

    /**
     * OrderController constructor.
     */
    public function __construct()
    {

        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = 5;

        $orderCount = MainRepository::getOrderCount();
        $paginator = $this->orderRepository->getAllOrders(10);



        \Meta::set('title','Список заказов');
        return view('blog.admin.order.index',compact('orderCount','paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->orderRepository->getId($id);
        if (empty($item))
            abort(404);

        $order = $this->orderRepository->getOneOrder($id);
        if (!$order)
            abort(404);
        $order_products = $this->orderRepository->getAllProductsId($item->id);

        \Meta::set('title',"Заказ №{$id}");

        return view('blog.admin.order.edit',compact('item','order','order_products'));

    }

    public function change($id){
        $result = $this->orderRepository->changeStatusOrder($id);
        if ($result)
            return redirect()->route('blog/admin.orders.edit',$id)->with(['success'=>'Успешно сохранено']);
        else
            return back()->withErrors(['msg'=>'Ошибка сорхранения']);

    }

    public function destroy($id)
    {   $result = $this->orderRepository->changeStatusOnDelete($id);

        if ($result){

            $st = Order::destroy($id);
            if ($st){
                return redirect()
                    ->route('blog/admin.orders.index')
                    ->with('success',"Запись №$id удалена");
            }else{
                return back()->withErrors(['msg'=>'Ошибка удаления']);
            }

        }else{
            return back()->withErrors(['msg'=>'Статус не изменен']);

        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function save(AdminOrderSaveRequest $request,$id){
            $result = $this->orderRepository->saveOrderComment($id);
            if ($result)
                return redirect()
                    ->route('blog/admin.orders.edit',$id)
                    ->with(['success'=>'Успешно сохранено']);
            else
                return back()->withErrors(['msg'=>'Ошибка сохранения']);
    }

    public function forcedestroy($id){
        if (empty($id))
            return back()->withErrors(['msg'=>'Запись не найдена']);
        $result = \DB::table('orders')->delete($id);

        if ($result)
            return redirect()
                ->route('blog/admin.orders.index')
                ->with(['success'=>'Успешно удалено']);
        else
            return back()->withErrors(['msg'=>'Ошибка удаления']);

    }


}
