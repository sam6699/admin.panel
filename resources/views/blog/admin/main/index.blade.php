@extends('layouts.app_admin')

@section('content')
        <section class="content-header">
            @component('blog.admin.components.breadcrumb')
                @slot('title') Панель управления @endslot
                @slot('parent')Главная @endslot
                @slot('active') @endslot
                @endcomponent
        </section>

    <section class="content">
        <div class="row">
         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-aqua">
                 <div class="inner">
                     <h4>Кол-во заказов: {{$orders}}</h4>
                     <p>Новые заказы</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-bag"></i>
                 </div>
                 <a href="" class="small-box-footer">Подробнее
                    <i class="fa fa-arrow-circle-o-right"></i>
                 </a>
             </div>
        </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Кол-во продуктов: {{$products}}</h4>
                        <p>Продукты</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">Подробнее
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Кол-во пользователей: {{$users}}</h4>
                        <p>Пользователи</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="" class="small-box-footer">Подробнее
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h4>Кол-во категорий: {{$categories}}</h4>
                        <p>Категории</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="" class="small-box-footer">Подробнее
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>



        </div>

        <div class="row">
            @include('blog.admin.main.include.orders')
            @include('blog.admin.main.include.recently')
        </div>

    </section>


@endsection