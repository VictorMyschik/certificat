@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container col-md-11 col-sm-12 m-t-10">
      {!! MrMessage::GetMessage() !!}
      <div class="row padding-horizontal">
        <mr-search-certificate></mr-search-certificate>
      </div>


    </div>

    <div class="modal fade" id="mr_modal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
