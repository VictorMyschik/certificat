@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div class="margin-b-15 margin-t-10">
        {!! MrBtn::loadForm('admin_office_edit', ['id'=>'0'], 'Создать пустой офис', ['btn btn-primary btn-sm']) !!}
      </div>
      {!! $table !!}
    </div>
  </div>
@endsection
