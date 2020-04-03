@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <table class="table table-hover table-striped table-bordered mr-middle">
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
              <a href="/admin/feedback/edit/{{ $value->id() }}"
                 class="btn btn-primary btn-sm mr-border-radius-5 fa fa-edit"></a>
              <a href="/admin/feedback/delete/{{ $value->id() }}" onclick="return confirm('Уверены?');"
                 class="btn btn-danger btn-sm mr-border-radius-5 fa fa-trash"></a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
