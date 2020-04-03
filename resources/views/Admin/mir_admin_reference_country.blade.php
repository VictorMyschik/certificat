@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="margin-b-15 margin-t-10">
        {!! MrBtn::loadForm('admin_reference_country_form_edit', ['id' => '0'], 'Новый', ['btn-success', 'btn-xs'], 'sm') !!}
        <a href="{{ route('reference_country') }}" onclick="return confirm('Вы уверены?');">
          <button type="button" title="Будет скачан с переустановлен с нуля" class="btn btn-primary btn-xs mr-border-radius-5">
            Переустановить справочник
          </button>
        </a>
      </div>
      {!! MrMessage::GetMessage() !!}
      {!! $table !!}
    </div>
  </div>
@endsection
