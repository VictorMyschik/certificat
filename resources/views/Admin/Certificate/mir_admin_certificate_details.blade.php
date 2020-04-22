@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-lg-9 col-md-10 col-sm-12 m-t-5 p-l-5 p-r-5">
      @include('certificate_view',['certificate'=>$certificate])
    </div>
  </div>
@endsection