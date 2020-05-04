@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      <mr-search-certificate></mr-search-certificate>
    </div>
  </div>
@endsection

