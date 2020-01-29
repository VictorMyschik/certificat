@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>№</td>
        <td>Имя</td>
        <td>Email</td>
        <td>Дата</td>
        <td>Отвечена</td>
        <td>#</td>
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
            <a href="/admin/feedback/edit/{{ $value->id() }}" class="btn btn-primary btn-sm mr-border-radius-5 fa fa-edit"></a>
            <a href="/admin/feedback/delete/{{ $value->id() }}" onclick="return confirm('Уверены?');" class="btn btn-danger btn-sm mr-border-radius-5 fa fa-trash-alt"></a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
