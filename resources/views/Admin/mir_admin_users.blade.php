@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="margin-b-15 margin-t-10">
        {!! MrBtn::loadForm('user_form_edit', ['id' => '0'], 'Добавить', ['btn-success btn-xs'],'xs') !!}
      </div>
      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td class="padding-horizontal">ID</td>
          <td class="padding-horizontal">Офис</td>
          <td class="padding-horizontal">ФИО</td>
          <td class="padding-horizontal">Контакты</td>
          <td class="padding-horizontal">Регистрация</td>
          <td class="padding-horizontal">Старт сессии</td>
          <td class="padding-horizontal">Конец сессии</td>
          <td class="padding-horizontal">Верификация</td>
          <td class="padding-horizontal">#</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
          <tr class="{{ $user->getBlock() ? 'mr-bg-red' : '' }}">
            <td class="padding-horizontal">{{ $user->id() }}</td>
            <td class="padding-horizontal">{{ $user->getDefaultOffice()?$user->getDefaultOffice()->getName():'' }}</td>
            <td class="padding-horizontal">{{ $user->getName() }}</td>
            <td class="padding-horizontal">
              {{ $user->getPhone() }}
              {{ $user->getEmail() }}
            </td>
            <td class="padding-horizontal"
                title="{{ $user->getDateFirstVisit()->getShortDateFullTime() }}">{{ $user->getDateFirstVisit()->getShortDate() }}</td>
            <td class="padding-horizontal"
                title="{{ $user->getDateLogin()->getShortDateFullTime() }}">{{ $user->getDateLogin()->getShortDate() }}</td>
            <td class="padding-horizontal"
                title="{{ $user->getDateLastVisit()->getShortDateFullTime() }}">{{ $user->getDateLastVisit()->getShortDate() }}</td>
            <td class="padding-horizontal"
                title="{{ $user->getDateVerify()?$user->getDateVerify()->getShortDateShortTime():null }}">{{ $user->getDateVerify()?$user->getDateVerify()->getShortDate():null }}</td>
            <td class="padding-horizontal">
              {!! MrBtn::loadForm('user_form_edit', ['id' => $user->id()], '', ['btn btn-primary btn-xs fa fa-edit'],'xs') !!}
              <a href="/admin/users/delete/{{ $user->id() }}"
                 onclick="return confirm('Уверены? Пользователь будет удалён полностью из системы');"
                 class="btn btn-danger btn-xs fa fa-trash mr-border-radius-5">
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td>ID</td>
          <td>Email</td>
          <td>Автор</td>
          <td>Офис</td>
          <td>Админ</td>
          <td>Дата</td>
          <td>#</td>
        </thead>
        <tbody>
        @foreach($new_users as $new_user)
          <tr>
            <td>{{ $new_user->id() }}</td>
            <td>{{ $new_user->getEmail() }}</td>
            <td>{{ $new_user->getUser()->GetFullname() }}</td>
            <td>{{ $new_user->getOffice()->getName() }}</td>
            <td>{{ $new_user->getIsAdmin()?'Админ':'Пользователь' }}</td>
            <td>{{ $new_user->getWriteDate()->getShortDateShortTime() }}</td>
            <td>
              {{ MrLink::open('new_user_delete', ['office_id'=>$new_user->getOffice()->id(),'id' => $new_user->id()], '', 'btn btn-danger btn-xs fa fa-trash','Удалить') }}
              {!! MrLink::open('resend_message_for_new_user', ['new_user_id' => $new_user->id()],'','btn btn-primary btn-xs fa fa-mail-reply','Переотправить') !!}
              <i class="fa fa-mail-reply"></i>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <div class="row col-md-12 d-inline-block">
        <h4>Блокировка пользователя</h4>
        {{ Form::open(['url'=>'/admin/users/block','method' => 'get', 'enctype'=>'multipart/form-data', 'files' => false]) }}
        {{ Form::token() }}
        <select class="mr-border-radius-10" name="user">
          <option value=0>[не выбрано]</option>
          @foreach($users as $user)
            @if($user->IsSuperAdmin())
              @continue
            @endif
            <option value="{{ $user->id() }}">{{ $user->getName().' ('.$user->getEmail().')' }}</option>
          @endforeach
        </select>

        <input type="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" name="date_to"
               class="mr-border-radius-10">
        <input type="time" min="{{  date('H:i') }}" value="{{  date('H:i') }}" name="date_time"
               class="mr-border-radius-10">

        <input name="description" type="text" placeholder="причина..." class="mr-border-radius-10">
        <button type="submit" class="btn btn-xs top btn-primary mr-border-radius-5">Блокировать</button>
        {!! Form::close() !!}
      </div>

      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td class="padding-horizontal">№</td>
          <td class="padding-horizontal">Имя</td>
          <td class="padding-horizontal">Email</td>
          <td class="padding-horizontal">Конец блокировки</td>
          <td class="padding-horizontal">Описание</td>
          <td class="padding-horizontal">Разблокировать</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users_blocked as $user_b)
          <tr>
            <td class="padding-horizontal">{{ $user_b->id() }}</td>
            <td class="padding-horizontal">{{ $user_b->getUser()->getName() }}</td>
            <td class="padding-horizontal">{{ $user_b->getUser()->getEmail() }}</td>
            <td class="padding-horizontal">{{ $user_b->getDateTo()->format('d M Y H:i') }}</td>
            <td class="padding-horizontal">{{ $user_b->getDescription() }}</td>
            <td class="padding-horizontal"><a href="/admin/users/unblock/{{ $user_b->id() }}">
                Разблокировать</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

