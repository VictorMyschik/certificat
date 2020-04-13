@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      {{Form::open(array('url' => '/test', 'files' => true))}}
      @csrf
      {{Form::file('file')}}
      {{Form::submit('Click Me!')}}
      {{ Form::close() }}
    </div>
  </div>
@endsection

