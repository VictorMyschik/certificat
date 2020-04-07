@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!! MrMessage::GetMessage() !!}
      <div class="margin-b-15 m-b-10">
      </div>
      <mr-table :mr_route="'{{ route('list_communicate_table') }}'"></mr-table>
    </div>
  </div>
@endsection

