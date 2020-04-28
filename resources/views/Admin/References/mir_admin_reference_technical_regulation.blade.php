@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="m-b-15">
        {!! MrBtn::loadForm('admin_reference_technical_regulation_form_edit', ['id' => '0'], 'Новый', ['btn', 'btn-success', 'btn-sm'],'md') !!}
      </div>
      {!! MrMessage::GetMessage() !!}
      <mr-table :mr_route="'{{ route($route_name) }}'"></mr-table>
    </div>
  </div>
@endsection
