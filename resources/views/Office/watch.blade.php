@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    {!! MrMessage::GetMessage() !!}
    <div class="col-md-10 col-sm-11 no-gutters m-t-15">
      <mr-certificate-watch></mr-certificate-watch>
    </div>
  </div>
@endsection
