@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      @include('Admin.layouts.page_title')
      <div class="d-inline-block">
        <h4>Список языков <span title="Редактировать">
       {!!  MrBtn::loadForm('admin_language_edit_form', ['id' => '0'],'Добавить язык', ['btn-primary', 'btn-sm']) !!}</span>
        </h4>
        {!!  MrMessage::GetMessage() !!}
        @foreach($languages as $language)
          <span class="mr-border-radius-10 mr-language-icon" title="{{$language->getDescription()}}"
                style="border: #0d152a 1px solid;padding-left: 5px;padding-right: 5px;color: #00A000;">{{$language->getName()}}</span>
        @endforeach
      </div>

      <div class="margin-b-15 m-t-10 m-b-10">
        {!! MrBtn::loadForm('translate_word_edit', ['id' => '0'], 'Добавить перевод',['btn-primary btn-sm']) !!}
      </div>
      <mr-table :mr_route="'{{$route_name}}'"></mr-table>
    </div>
  </div>
@endsection

