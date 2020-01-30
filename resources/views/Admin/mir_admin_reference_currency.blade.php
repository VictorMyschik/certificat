@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_reference_currency_form_edit',
'Admin\\MrAdminReferenceCurrencyEditForm', ['id' => '0'], 'Новый', ['btn', 'btn-success', 'btn-xs'],'md') !!}

    </div>
    {!! MrMessage::GetMessage() !!}
    {!! $table !!}
  </div>
@endsection
