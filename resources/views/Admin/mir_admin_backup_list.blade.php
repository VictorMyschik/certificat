@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="m-b-15">
        <a class="btn btn-primary btn-sm mr-border-radius-5"
           href="{{route('artisan_migrate')}}">Запустить миграцию</a>
        <p><i class="fa fa-info-circle mr-color-green"></i>Будут созданы таблицы из файлов, отсутствующие в БД</p>
        <div><i class="fa fa-info-circle mr-color-green"></i>Кнопка <a class="btn btn-primary btn-sm mr-border-radius-5"
                                                                       href="#">Recovery</a> восстановит данные
        </div>
      </div>
      @include('layouts.Elements.table', ['route_name'=>$route_name])
    </div>
  </div>
@endsection

