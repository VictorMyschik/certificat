@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    {!! MrMessage::GetMessage() !!}
    <div class="row no-gutters">
      <mr-certificate-watch></mr-certificate-watch>
    </div>
  </div>
@endsection
