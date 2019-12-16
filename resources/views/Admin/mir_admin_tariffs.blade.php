@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!!  MrMessage::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('tariff_edit', 'Admin\\MrAdminTariffEditForm', ['id' => '0'], 'Новый тариф',['btn-success btn-xs']) !!}
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td>ID</td>
        <td>Наименование</td>
        <td>Категория</td>
        <td>Измерение</td>
        <td>Цена</td>
        <td>Примечание</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getName() }}</td>
          <td>{{ $value->getCategoryName() }}</td>
          <td>{{ $value->getMeasureName() }}</td>
          <td>{{ $value->getCost() }}</td>
          <td>{{ $value->getDescription() }}</td>
          <td>
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('tariff_edit', 'Admin\\MrAdminTariffEditForm', ['id' => $value->id()], '',['btn-primary btn-xs fa fa-edit']) !!}
            <a href="/admin/tariff/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');"
               class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
