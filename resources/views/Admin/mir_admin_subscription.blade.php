@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div class="m-b-15">
        {{ Form::open(['url'=>'/admin/subscription/new/','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => false]) }}
        {{ Form::token() }}
        <label>
          <input name="email" type="text" required placeholder="Email" class="mr-border-radius-5 padding-horizontal">
        </label>
        <button type="submit" class="btn btn-primary btn-xs mr-border-radius-5">Подписать</button>
        {!! Form::close() !!}
      </div>

      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td class="padding-horizontal">№</td>
          <td class="padding-horizontal">Email</td>
          <td class="padding-horizontal">Дата</td>
          <td class="padding-horizontal">Del</td>
        </tr>
        </thead>
        <tbody>
        @foreach($emails as $email)
          <tr>
            <td class="padding-horizontal">{{ $email->id() }}</td>
            <td class="padding-horizontal">{{ $email->getEmail() }}</td>
            <td class="padding-horizontal">{{ $email->getDate()->format('d M Y H:i') }}</td>
            <td class="padding-horizontal">
              <a href="/admin/subscription/delete/{{ $email->id() }}"
                 onclick="return confirm('Отписать Email: {{ $email->getEmail() }} от рассылки');">
                <button type="button" class="btn btn-danger btn-xs mr-border-radius-5">Отписать</button>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
