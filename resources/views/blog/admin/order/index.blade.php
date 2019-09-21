@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Панель управления @endslot
            @slot('parent')Главная @endslot
            @slot('active') Заказы @endslot
        @endcomponent
    </section>

    <section class="content-header">
            <h1>Список заказов</h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i></a></li>
            </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginator as $order)
                                    @php $class = $order->status ? 'success':'' @endphp
                                    <tr class="{{$class}}">
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>
                                            @if($order->status==0)Новый@endif
                                            @if($order->status==1)Завершен@endif
                                            @if($order->status==2)Удален@endif
                                        </td>
                                        <td>{{$order->sum}}{{$order->currency}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->updated_at}}</td>
                                        <td>
                                            <a href="{{route('blog/admin.orders.edit',[$order->id])}}"><i class="fa fa-fw fa-eye"></i></a>
                                            <a href="{{route('blog.admin.orders.forcedestroy',$order->id)}}"><i class="fa fa-fw fa-close text-danger deletedb"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center" colspan="3">
                                        <h2>Заказов нет</h2>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{count($paginator)}} заказа(ов) {{$orderCount}}</p>
                            <p>{{$paginator->total()}}--{{$paginator->count()}}</p>
                            @if($paginator->total()>$paginator->count())
                                <br>
                                <div class="row justify-content_center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{$paginator->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection