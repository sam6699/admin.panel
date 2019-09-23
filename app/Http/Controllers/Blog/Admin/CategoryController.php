<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends AdminBaseController
{

    private $categoryRepository;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);

    }

    /**
     * CategoryController constructor.
     */



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $arrMenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrMenu);


        \Meta::set('title','Список категорий');

        return view('blog.admin.category.index',['menu'=>$menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Category();
        $categoryList = $this->categoryRepository->getComboBosCategories();

        \Meta::set('title','Создание категории');

        return view('blog.admin.category.create',[
            'categories'=>Category::with('children')
                ->where('parent_id','0')
                ->get(),
            'delimiter'=>'-',
            'item'=>$item

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unique = $this->categoryRepository->checkUnique($request->title,$request->parent_id);
        if ($unique)
            return back()->withErrors(['msg'=>'Категория уже существует'])
                ->withInput();

        $data = $request->input();

        $category = new Category();

        $result = $category->fill($data)->save();

        if ($result)
            return redirect()
                ->route('blog.admin.categories.create',[$category->id])
                ->with(['success'=>'Категория успешно создана']);
        else
            return back()->withErrors(['msg'=>'Ошибка невозможно создать'])
                    ->withInput();






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
    public function edit($id,CategoryRepository $categoryRepository)
    {

        $item = $this->categoryRepository->getId($id);
            if (empty($item))
                abort(404);

        \Meta::set('title','Изменение категории');
        return view('blog.admin.category.edit',
            [
                'categories'=>Category::with('children')
                ->where('parent_id','0')
                ->get(),
                'delimiter'=>'-',
                'item'=>$item
            ]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->categoryRepository->getId($id);

        if (empty($item))
            return back()->withErrors(['msg'=>"Запись {{$id}} не найдена"])->withInput();

        $data = $request->all();
        $result = $item->update($data);
        if ($result)
            return redirect()
                ->route('blog.admin.categories.edit',$id)
                ->with(['success'=>'Успешно сохранено']);
        else
            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mydel(){
            $result = $this->categoryRepository->getRequestID();
            if(!$result)
                return back()->withErrors(['msg'=>'Неверный ID']);

            $children = $this->categoryRepository->checkChildren($result);

            if ($children)
                return back()->withErrors(['msg'=>'Невозможно удалить, в категории присутствуют подкатегории']);

            $parent = $this->categoryRepository->checkParentsProducts($result);

            if ($parent)
                return back()->withErrors(['msg'=>'Невозможно удалить, в категории присутствуют продукты ']);

            $id = $this->categoryRepository->delete($result);
            if ($id)
                return redirect()
                    ->route('blog.admin.categories.index')
                    ->with(['success'=>"Категория №$result удалена"]);
            else
                return back()->withErrors(['msg'=>'Ошибка удаления']);


    }
}
