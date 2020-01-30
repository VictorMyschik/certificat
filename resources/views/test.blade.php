@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
  <div class="container">
    {!! $table !!}
  </div>
@endsection

