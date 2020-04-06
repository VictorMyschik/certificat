@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10 ">
      <div class="padding-horizontal-0">
        <h4 class="mr-bold">{{$page_title}}</h4>
      </div>
      <mr-table :mr_route="'{{ route($route_name) }}'"></mr-table>
    </div>
  </div>
@endsection