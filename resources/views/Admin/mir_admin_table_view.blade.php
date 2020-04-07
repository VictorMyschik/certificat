@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      {!! MrLink::open('admin_backup_page',[],'Назад','btn btn-primary btn-xs') !!}
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      @include('layouts.Elements.table', ['route_name'=>$route_name])
    </div>
  </div>
@endsection
