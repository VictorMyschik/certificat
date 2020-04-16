@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-lg-10 col-md-12 m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="m-b-10">
        {!! Form::open(['route' => 'admin_certificate_update_from_url','method' => 'post']) !!}
        @csrf
        {!! Form::text('url','',['class'=>'mr-border-radius-10 form-control float-left col-md-3','placeholder'=>'URL или ID']) !!}
        {!! Form::submit('загрузить',['class'=>['btn btn-success mr-border-radius-10']]) !!}
        {!! Form::close() !!}
      </div>
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection

