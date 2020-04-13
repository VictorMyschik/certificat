@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="margin-b-15 m-b-10">
        {!! MrBtn::loadForm('admin_manufacturer_load_edit', [], 'Загрузить из XML', ['btn-success', 'btn-sm'], 'sm') !!}
      </div>
      <mr-table :mr_route="'{{ route('list_manufacturer_table') }}'"></mr-table>
    </div>
  </div>
@endsection

