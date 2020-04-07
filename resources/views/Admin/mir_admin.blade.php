@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="card-body padding-horizontal-0">
          <mr-admin-redis-data></mr-admin-redis-data>
      </div>
    </div>
  </div>
@endsection
