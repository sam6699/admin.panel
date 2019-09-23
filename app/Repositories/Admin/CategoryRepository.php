<?php
/**
 * Created by PhpStorm.
 * User: Samm
 * Date: 22.09.2019
 * Time: 12:25
 */

namespace App\Repositories\Admin;


use App\Models\Admin\Category;
use App\Repositories\CoreRepository;



class CategoryRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }


    protected function getModelClass()
    {
       return Category::class;
    }

    public function buildMenu($arrMenu){
            $mBuilder = \Menu::make('MyNav',function ($m) use ($arrMenu){
               foreach ($arrMenu as $item){
                   if ($item->parent_id==0){
                       $m->add($item->title,$item->id)->id($item->id);
                   }else{
                       if ($m->find($item->parent_id)){
                           $m->find($item->parent_id)->add($item->title,$item->id)->id($item->id);

                       }

                   }



               }

            });

            return $mBuilder;

    }

    public function checkChildren($id){
        $result = $this->startConditions()
            ->where('parent_id',$id)
            ->count();

        return $result;

    }

    public function checkParentsProducts($id){
        $result = \DB::table('products')
            ->where('category_id',$id)
            ->count();

        return $result;
    }

    public function delete($id){
        $result = $this->startConditions()
            ->find($id)
            ->forceDelete();
        return $result;
    }

    public function getComboBosCategories(){
        $column = implode(',',[
            'id',
            'parent_id',
            'title',
            'CONCAT(id, ". ",title) AS combo_title'

        ]);

        $result = $this->startConditions()
            ->selectRaw($column)
            ->toBase()
            ->get();

        return $result;
    }

    public function checkUnique($title,$parent_id){
        $result = $this->startConditions()
            ->where('title','=',$title)
            ->where('parent_id',$parent_id)
            ->exists();

        return $result;
    }




}