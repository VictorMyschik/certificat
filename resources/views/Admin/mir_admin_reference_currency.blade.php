@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="margin-b-15 margin-t-10">
        {!! MrBtn::loadForm('admin_reference_currency_form_edit', ['id' => '0'], 'Новый', ['btn', 'btn-success', 'btn-xs'],'md') !!}
      </div>
      {!! MrMessage::GetMessage() !!}
      {!! $table !!}
    </div>
  </div>
@endsection
