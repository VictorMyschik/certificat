@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="margin-b-15 margin-t-10">
          {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('user_edit', 'Admin\\MrUserEditForm', ['id' => '0'], 'Добавить',['btn btn-info btn-xs']) !!}
        </div>
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td class="padding-horizontal">№</td>
            <td class="padding-horizontal">Login</td>
            <td class="padding-horizontal">ФИО</td>
            <td class="padding-horizontal">Контакты</td>
            <td class="padding-horizontal">Регистрация</td>
            <td class="padding-horizontal">Старт сессии</td>
            <td class="padding-horizontal">Конец сессии</td>
            <td class="padding-horizontal">Подписка</td>
            <td class="padding-horizontal">#</td>
          </tr>
          </thead>
          <tbody>
          @foreach($users as $user)
            <tr class="{{ $user->getBlock() ? 'mr-bg-red' : '' }}">
              <td class="padding-horizontal">{{ $user->id() }}</td>
              <td class="padding-horizontal">{{ $user->getName() }}</td>
              <td class="padding-horizontal">{{ $user->GetFullName() }}</td>
              <td class="padding-horizontal">
                {{ $user->getPhone() }}
                {{ $user->getEmail() }}
              </td>
              <td class="padding-horizontal">{{ $user->getDateFirstVisit()->format('d M Y H:i') }}</td>
              <td class="padding-horizontal">{{ $user->getDateLogin()->format('d M Y H:i') }}</td>
              <td class="padding-horizontal">{{ $user->getDateLastVisit()->format('d M Y H:i') }}</td>
              <td class="padding-horizontal">
                {!!  $user->getIsSubscription()?'<div>да</div><div><a class="mr-border-radius-10" href="/unsubscription/'.\App\Models\MrSubscription::loadBy($user->getEmail(),'Email')->getToken().'?return=true"><span class="mr-color-red">отписать</span></a></div>':'<div>нет</div><div><a class="mr-border-radius-10" href="/subscription?return=true&email='.$user->getEmail().'"><span class="mr-color-green-dark">подписать</span></a></div>' !!}
              </td>
              <td class="padding-horizontal">
                {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('user_edit', 'Admin\\MrUserEditForm', ['id' => $user->id()],'',['btn btn-info btn-xs fa fa-edit']) !!}
                <a href="/admin/users/delete/{{ $user->id() }}"
                   onclick="return confirm('Уверены? Пользователь будет удалён полностью из системы');">
                  <button type="button" class="btn btn-danger btn-xs fa fa-trash mr-border-radius-5"></button>
                </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <hr>
    </div><!-- .content -->
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="row col-md-12 d-inline-block">
          <h4>Блокировка пользователя</h4>
          {{ Form::open(['url'=>'/admin/users/block','method' => 'get', 'enctype'=>'multipart/form-data', 'files' => false]) }}
          {{ Form::token() }}
          <select class="mr-border-radius-10" name="user">
            <option value=0>[не выбрано]</option>
            @foreach($users as $user)
              @if($user->IsAdmin())
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

        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
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
  </div>
  <script src="/public/vendors/jquery/dist/jquery.min.js"></script>
  <script src="/public/vendors/popper.js/dist/umd/popper.min.js"></script>
  <script src="/public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="/public/js/js/main.js"></script>

  <script src="/public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/public/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="/public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="/public/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="/public/vendors/jszip/dist/jszip.min.js"></script>
  <script src="/public/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="/public/vendors/pdfmake/build/vfs_fonts.js"></script>
  <script src="/public/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="/public/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="/public/vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
  <script src="/public/js/js/init-scripts/data-table/datatables-init.js"></script>
@endsection

