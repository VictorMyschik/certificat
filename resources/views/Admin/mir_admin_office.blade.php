@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!!  MrMessage::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_office_edit', 'Admin\\MrOfficeEditForm', ['id'=>'0'], 'Создать пустой офис', ['btn btn-primary btn-xs']) !!}
    </div>
    {!! $table !!}
  </div>
@endsection
