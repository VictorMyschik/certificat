@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    {!! MrMessage::GetMessage() !!}
    <div class="row no-gutters">
      <mr-search-certificate-page :history='{!!json_encode($user_history)!!}' :can_edit='{{ json_encode($can_edit) }}'></mr-search-certificate-page>
    </div>
  </div>
@endsection
