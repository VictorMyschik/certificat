@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    {!! MrMessage::GetMessage() !!}
    <div class="row no-gutters">
      <mr-search-certificate></mr-search-certificate>
    </div>

    <div class="row no-gutters">
      <mr-my-certificate></mr-my-certificate>
    </div>


  </div>
@endsection
