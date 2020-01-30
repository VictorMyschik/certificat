@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_reference_country_form_edit',
'Admin\\MrAdminReferenceCountryEditForm', ['id' => '0'], 'Новый', ['btn-success', 'btn-xs'], 'sm') !!}
      <a href="{{ route('reference_country') }}" onclick="return confirm('Вы уверены?');">
        <button type="button" title="Будет скачан с переустановлен с нуля"
                class="btn btn-primary btn-xs mr-border-radius-5">
          Переустановить справочник
        </button>
      </a>
    </div>
    {!! MrMessage::GetMessage() !!}
    <table class="table table-hover table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>ID</td>
        <td>Наименование</td>
        <td>English</td>
        <td>Код 1</td>
        <td>Код 2</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getNameRus() }}</td>
          <td>{{ $value->getNameEng() }}</td>
          <td>{{ $value->getNumericCode() }}</td>
          <td>{{ $value->getCode() }}</td>
          <td>
            {!! MrBtn::loadForm('admin_reference_country_form_edit',
            'Admin\\MrAdminReferenceCountryEditForm', ['id' => $value->id()], '', ['btn-primary', 'btn-xs', 'fa', 'fa-edit'])
            !!}
            <a href="{{ route('reference_item_delete',['name'=>'country','id'=>$value->id()]) }}"
               onclick="return confirm('Вы уверены?');" class="btn btn-danger btn-xs mr-border-radius-5 fa fa-trash-alt">
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
