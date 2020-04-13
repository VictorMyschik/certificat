@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      {!! MrLink::open('delete_bd_log',[],'Очистить всё','btn btn-danger btn-sm','',['onclick'=>'return confirm("Всё удалить?");']) !!}
      @include('Admin.layouts.page_title')
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection
