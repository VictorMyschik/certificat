@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="m-b-10">
        <a href="{{ route('admin_email_delete',['id'=>-1]) }}" title="Создать новую запись"
           class="btn btn-danger btn-sm mr-border-radius-5 fa fa-trash-alt"
           onclick="return confirm('Всё удалить! Продолжить?');"> Удалить всё
        </a>
      </div>
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection