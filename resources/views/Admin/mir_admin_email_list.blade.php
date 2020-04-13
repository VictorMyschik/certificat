@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container p-t-15">
    @include('Admin.layouts.page_title')
    {!!  MrMessage::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_email_send_edit', 'Admin\\MrAdminEmailSendForm',[], 'Новое сообщение', ['btn-primary', 'btn-sm'],'xs') !!}
      <a href="{{ route('admin_email_delete',['id'=>-1]) }}" title="Создать новую запись"
         class="btn btn-danger btn-sm mr-border-radius-5 fa fa-trash-alt"
         onclick="return confirm('Всё удалить! Продолжить?');"> Удалить всё
      </a>
    </div>
    <table class="table table-hover table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>ID</td>
        <td>User</td>
        <td>Email to</td>
        <td>Title</td>
        <td>Дата</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $email)
        <tr>
          <td>{{ $email->id() }}</td>
          <td>{{ $email->getUser()->getName() }}</td>
          <td>{{ $email->getEmail() }}</td>
          <td>{{ $email->getTitle() }}</td>
          <td>{{ $email->getWriteDate()->getShortDateShortTime() }}</td>
          <td>
            {!! MrBtn::loadForm('email_info_popup_edit', 'Admin\\MrAdminEmailInfoForm', ['id'=> $email->id()], 'info', ['btn-primary', 'btn-sm'],'xs') !!}
            <a href="{{ route('admin_email_delete', ['id'=>$email->id()]) }}" title="Создать новую запись"
               class="btn btn-danger btn-sm mr-border-radius-5 fa fa-trash-alt"
               onclick="return confirm('Письмо будет удалено. Продолжить?');">
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection