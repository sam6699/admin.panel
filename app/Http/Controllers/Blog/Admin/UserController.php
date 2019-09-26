<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\AdminUserEditRequest;
use App\Models\Admin\User;
use App\Models\UserRole;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\UserRepository;

class UserController extends AdminBaseController
{
    private $userRepository;
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $per_page = 8;
        $count = MainRepository::getUsersCount();
        $paginator = $this->userRepository->getAllUsers($per_page);


        \Meta::set('title','Список пользователей');
        return view('blog.admin.user.index',compact('count','paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \Meta::set('title','Добавение пользователся');
        return view('blog.admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserEditRequest $request)
    {
        $role_id=(int)$request['role'];
        $user = User::create(
            [
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>bcrypt($request['password']),
            ]
        );


        if (!$user)
            return back()->withErrors(['msg'=>'Ошибка создания']);
        else{

//            dd($role_id);
                $role = UserRole::create(
                    [
                        'user_id'=>$user->id,
                        'role_id'=>$role_id,
                    ]
                );




            if (!$role){
                return back()->withErrors(['msg'=>'Ошибка создания'])->withInput();
            }else{
                return redirect()
                    ->route('blog.admin.users.index')
                    ->with(['success'=>'Успешно создано']);


            }



        }




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
        $per_page=10;
        $user = $this->userRepository->getId($id);



        if (empty($user))
            abort(404);

        $orders = $this->userRepository->getUserOrders($id,$per_page);
        $role = $this->userRepository->getUserRole($id);
        $count = $this->userRepository->getCountOrdersPerPag($id);
        $count_orders = $this->userRepository->getCountOrders($id,$per_page);

        \Meta::set('title','Редактирование пользователя');
        return view('blog.admin.user.edit',compact('user','orders','role','count','count_orders'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserEditRequest $request,User $user,UserRole $userRole)
    {
        $user->name = $request['name'];
        $user->email = $request['email'];
        $request['password'] = null?:$user->password = bcrypt($request['password']);
        $save = $user->save();
        if (!$save){
            return back()->withErrors(['msg'=>'Ошибка сохранения']);
        }else{
            $userRole->where('user_id',$user->id)->update(['role_id'=>(int)$request['role']]);
            return redirect()
                ->route('blog.admin.users.edit',$user->id)
                ->with(['success'=>'Успешно сохранено']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        dd($user);
        $result = $user->forceDelete();
        if ($result){
            return redirect()
                ->route('blog.admin.users.index')
                ->with(['success'=>'Пользователь '.ucfirst($user->name).' удален']);
        }else{
            return back()->withErrors(['msg'=>'Ошибка удаления']);
        }
    }
}
