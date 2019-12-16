@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!!  MrMessage::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_edit', 'Admin\\MrAdminOfficeEditForm', ['id' =>'0'], 'Создать пустой офис', ['btn btn-primary btn-xs']) !!}
    </div>
    <table class="table table-striped mr-middle">
      <thead>
      <tr>
        <td>ID</td>
        <td>Наименование</td>
        <td>Админ(ы)</td>
        <td>Тарифы</td>
        <td>Примечание</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getName() }}</td>
          <td>
            @foreach($value->GetUsers() as $admin)
              {{ $admin->getUser()->GetFullName() }}
            @endforeach
          </td>
          <td>
            @foreach($value->GetTariffs() as $til)
              <div>{{ $til->getTariff()->getName() }}</div>
            @endforeach
          </td>
          <td>{{ $value->getDescription() }}</td>
          <td>
            <a href="{{ route('office_page',['id'=>$value->id()]) }}"
               class="btn btn-primary btn-xs mr-border-radius-5">
              <i class="fa fa-eye"></i></a>
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_edit', 'Admin\\MrAdminOfficeEditForm', ['id' =>$value->id()], '', ['btn btn-info btn-xs fa fa-edit']) !!}
            <a href="/admin/office/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
              <button type="button" class="btn btn-danger btn-xs mr-border-radius-5"><i class="fa fa-trash"></i>
              </button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
