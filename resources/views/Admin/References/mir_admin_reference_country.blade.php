@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="margin-b-15 m-b-10">
        {!! MrBtn::loadForm('admin_reference_country_form_edit', ['id' => '0'], 'Новый', ['btn-success', 'btn-xs'], 'sm') !!}
        <a href="{{ route('reference_country') }}" onclick="return confirm('Вы уверены?');"></a>
      </div>
      {!! MrMessage::GetMessage() !!}
      <mr-table :mr_route="'{{ route($route_name) }}'"></mr-table>
    </div>
  </div>
@endsection
