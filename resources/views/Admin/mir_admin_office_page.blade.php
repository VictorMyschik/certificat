@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="row col-md-9">

          <div class="d-inline-flex col-md-9">
            <h4>Персональные данные</h4>
            <h5>{{ $office->getName() }}</h5>
          </div>

          <div class="d-inline-flex col-md-3">
            <h4>Подключенные тарифы
              {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_tariffs_edit', 'Admin\\MrAdminOfficeTariffEditForm', ['id' => $office->id()], 'Добавить тариф', ['btn btn-info btn-sm']) !!}
            </h4>
            <table id="" class="table table-striped table-bordered mr-middle">
              <thead>
              <tr>
                <td>Тариф</td>
                <td>Добавлен</td>
                <td>#</td>
              </tr>
              </thead>
              <tbody>
              @foreach($office->GetTariffs() as $tariff)
                <tr>
                  <td class="padding-horizontal">{{ $tariff->getTariff()->getName() }}</td>
                  <td class="padding-horizontal">{{ $tariff->getCreateDate()->getShortDate() }}</td>
                  <td>
                    <a href="{{ route('tariff_office_delete',['id'=>$tariff->id()]) }}"
                       class="btn btn-danger btn-sm mr-border-radius-5"
                       onclick="return confirm('Уверены?');"><i class="fa fa-trash-o"></i></a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>

        </div>

        <div class="">
          <div class="d-inline-flex col-md-9">
            <h4>Пользователи
              {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_user_edit', 'Admin\\MrAdminOfficeUserEditForm', ['id' => $office->id()], 'Добавить пользователя', ['btn btn-info btn-sm']) !!}
            </h4>
            <table id="" class="table table-striped table-bordered mr-middle">
              <thead>
              <tr>
                <td>ФИО</td>
                <td>Почта</td>
                <td>Admin</td>
                <td>#</td>
              </tr>
              </thead>
              <tbody>
              @foreach($office->GetUsers() as $user_in_office)
                <tr>
                  <td class="padding-horizontal">{{ $user_in_office->getUser()->getName() }}</td>
                  <td class="padding-horizontal">{{ $user_in_office->getUser()->getEmail() }}</td>
                  <td class="padding-horizontal">{{ $user_in_office->getIsAdmin()?'админ':'' }}</td>
                  <td>

                    <a href="{{ route('user_office_toggle_admin',['id'=>$user_in_office->id()]) }}"
                       class="btn btn-info btn-sm mr-border-radius-5" title="админ/не админ"><i class="fa fa-pagelines"></i></a>

                    <a href="{{ route('user_office_delete',['id'=>$user_in_office->id()]) }}"
                       class="btn btn-danger btn-sm mr-border-radius-5"
                       onclick="return confirm('Уверены?');"><i class="fa fa-trash-o"></i></a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>

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
