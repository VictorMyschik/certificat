@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="margin-b-15 m-b-10">
        <button class="btn-primary btn-sm">Загрузить из XML</button>
      </div>
      <mr_admin_certificates_list></mr_admin_certificates_list>
    </div>
  </div>
@endsection

