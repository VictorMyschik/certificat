@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    {!! MrMessage::GetMessage() !!}
    <div class="container col-md-11 m-t-15">
      <mr-certificate-watch></mr-certificate-watch>
    </div>
  </div>
@endsection
