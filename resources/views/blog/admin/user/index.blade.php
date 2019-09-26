@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Список пользователей @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список пользователей @endslot
        @endcomponent
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
                                    <td>ID</td>
                                    <td>Логин</td>
                                    <td>EMAIL</td>
                                    <td>Имя</td>
                                    <td>Роль</td>
                                    <td>Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginator as $user)
                                    @php
                                        $class = '';
                                        $status = $user->role;
                                    if ($status=='disabled') $class="danger";
                                    @endphp
                                    <tr class="{{$class}}">
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{ucfirst($user->name)}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>
                                            <a href="{{route('blog.admin.users.edit',$user->id)}}" title="посмотреть пользователя">
                                                <i class="btn btn-xs"></i>
                                                <button type="submit" class="btn btn-success">Посмотреть</button>
                                            </a>

                                            <a href="" class="btn btn-xs">
                                                <form action="{{route('blog.admin.users.destroy',$user->id)}}" method="post" style="float: none">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="submit" class="btn btn-danger delete" value="Удалить">


                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h2>Пользователей нет</h2>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{count($paginator)}} пользователей из {{$count}}</p>
                            @if($paginator->total()>$paginator->count())
                                <br>
                                <div class="row justify-content-center">
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