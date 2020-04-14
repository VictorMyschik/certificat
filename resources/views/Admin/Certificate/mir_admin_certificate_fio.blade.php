@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="margin-b-15 m-b-10"></div>
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection