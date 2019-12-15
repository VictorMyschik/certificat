@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td>№</td>
        <td>Имя</td>
        <td>Email</td>
        <td>Дата</td>
        <td>Отвечена</td>
        <td>Удалить</td>
      </tr>
      </thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td class="padding-horizontal">{{ $value->id() }}</td>
          <td class="padding-horizontal">{{ $value->getName() }}</td>
          <td class="padding-horizontal">{{ $value->getEmail() }}</td>
          <td class="padding-horizontal">{{ date('d M Y', strtotime($value->getDate())) }}</td>
          <td class="padding-horizontal">{{ $value->getSendMessage() ? 'Да': 'Нет' }}</td>
          <td>
            <a href="/admin/feedback/edit/{{ $value->id }}">
              <button type="button" class="btn btn-info btn-sm mr-border-radius-5"><i class="fa fa-eye"></i>
              </button>
            </a>
            <a href="/admin/feedback/delete/{{ $value->id() }}" onclick="return confirm('Уверены?');">
              <button type="button" class="btn btn-danger btn-sm mr-border-radius-5"><i class="fa fa-trash"></i>
              </button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
