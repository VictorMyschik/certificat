@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_reference_currency_form_edit',
'Admin\\MrAdminReferenceCurrencyEditForm', ['id' => '0'], 'Новый', ['btn', 'btn-success', 'btn-xs'],'md') !!}
      <a href="{{ route('reference_currency') }}" onclick="return confirm('Вы уверены?');">
        <button type="button" title="Будет скачан с переустановлен с нуля"
                class="btn btn-primary btn-xs mr-border-radius-5">
          Переустановить справочник
        </button>
      </a>
    </div>
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td>ID</td>
        <td>Наименование</td>
        <td>Код 1</td>
        <td>Код 2</td>
        <td>Дата с</td>
        <td>Дата по</td>
        <td>Округление</td>
        <td>Примечание</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getName() }}</td>
          <td>{{ $value->getCode() }}</td>
          <td>{{ $value->getTextCode() }}</td>
          <td>{{ $value->getDateFrom()?$value->getDateFrom()->getShortDate() : null}}</td>
          <td>{{ $value->getDateTo()?$value->getDateTo()->getShortDate() : null}}</td>
          <td>{{ $value->getRounding() }}</td>
          <td>{{ $value->getDescription() }}</td>
          <td>
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_reference_currency_form_edit',
            'Admin\\MrAdminReferenceCurrencyEditForm', ['id' => $value->id()], '', ['btn', 'btn-primary', 'btn-xs', 'fa', 'fa-edit'],'sm')
            !!}
            <a href="/admin/reference/currency/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
              <button type="button" class="btn btn-danger btn-xs mr-border-radius-5"><i class="fa fa-trash"></i>
              </button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
