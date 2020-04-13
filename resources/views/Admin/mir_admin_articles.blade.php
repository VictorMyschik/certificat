@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div>
        {!! MrLink::open('admin_article_edit',['id' =>0],'New','btn btn-primary btn-sm mr-border-radius-5 m-b-10') !!}
      </div>
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection
