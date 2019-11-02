@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="row col-md-9 margin-b-10" style="border-bottom: #0c175b 1px solid">
          <div class="d-inline-flex col-md-8">
            <h4>Персональные данные

              <div class="mr-bold mr-middle margin-b-10"
                   style="border-bottom: #0c175b 1px solid">Офис создан: {{ $office->getCreateDate() }} |
                Примечание: {{ $office->getDescription() }}</div>
            </h4>
            <div class="col-md-12 mr-middle padding-0">
              <h5 class="mr-bold margin-b-5">
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_details_edit', 'Admin\\MrAdminOfficeDetailsEditForm', ['id' => $office->id()], '', ['btn btn-info btn-xs fa fa-edit']) !!}
                Контактная информация и лицо с правом подписи</h5>
              <div class="d-inline-flex col-md-6 padding-0">

                <div>
                  <span class="mr-bold">Телефон:</span>
                  <span>{{ $office->getPhone() }}</span>
                </div>
                <div>
                  <span class="mr-bold">ПО Почтовый индекс:</span>
                  <span>{{ $office->getPOPostalCode() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Регион:</span>
                  <span>{{ $office->getPORegion() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Город:</span>
                  <span>{{ $office->getPOCity() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Адрес:</span>
                  <span>{{ $office->getPOAddress() }}</span>
                </div>
              </div>
              <div class="d-inline-flex col-md-6 padding-0">
                <div>
                  <span class="mr-bold">Страна:</span>
                  <span>{{ $office->getCountry() ? $office->getCountry()->getNameRus():null }}</span>
                </div>

                <div>
                  <span class="mr-bold">УНП:</span>
                  <span>{{ $office->getUNP() }}</span>
                </div>

                <div>
                  <span class="mr-bold">Email:</span>
                  <span>{{ $office->getEmail() }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-12 mr-middle margin-t-15 padding-0">
              <h5 class="mr-bold margin-b-5">
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_details_edit', 'Admin\\MrAdminOfficeDetailsEditForm', ['id' => $office->id()], '', ['btn btn-info btn-xs fa fa-edit']) !!}
                Юридическая информация</h5>
              <div class="d-inline-flex col-md-6 padding-0">
                <div>
                  <span class="mr-bold">Почтовый индекс:</span>
                  <span>{{ $office->getURPostalCode() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Регион:</span>
                  <span>{{ $office->getURRegion() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Город:</span>
                  <span>{{ $office->getURCity() }}</span>
                </div>
                <div>
                  <span class="mr-bold">ЮР Адрес:</span>
                  <span>{{ $office->getURAddress() }}</span>
                </div>
              </div>

              <div class="d-inline-flex col-md-6 padding-0">
                <div>
                  <span class="mr-bold">Банк р/с:</span>
                  <td>{{ $office->getBankRS() }}</td>
                </div>
                <div>
                  <span class="mr-bold">Имя банка:</span>
                  <span>{{ $office->getBankName() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Код банка:</span>
                  <span>{{ $office->getBankCode() }}</span>
                </div>
                <div>
                  <span class="mr-bold">Адрес банка:</span>
                  <span>{{ $office->getBankAddress() }}</span>
                </div>
              </div>
            </div>

            <div class="col-md-12 mr-middle margin-t-15 padding-0">
              <h4><u>Лицо с правом подписи</u></h4>
              <div>
                <span class="mr-bold">Должность:</span>
                <span>{{ $office->getPersonPost() }}</span>
              </div>
              <div>
                <span class="mr-bold">ФИО:</span>
                <span>{{ $office->getPersonFIO() }}</span>
              </div>
              <div>
                <span class="mr-bold">Основание:</span>
                <span>{{ $office->getPersonSign() }}</span>
              </div>
            </div>
          </div>

          <div class="d-inline-flex col-md-4 col-sm-12">
            <div class="">
              <h4>
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_tariffs_edit', 'Admin\\MrAdminOfficeTariffEditForm', ['id' => $office->id()], 'Добавить', ['btn btn-info btn-xs']) !!}
                Тарифы ВО</h4>
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
                         class="btn btn-danger btn-xs mr-border-radius-5"
                         onclick="return confirm('Уверены?');"><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="">
          <div class="d-inline-flex col-md-9">
            <h4>Пользователи ВО
              {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_user_edit', 'Admin\\MrAdminOfficeUserEditForm', ['id' => $office->id()], 'Добавить пользователя', ['btn btn-info btn-xs']) !!}
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
                       class="btn btn-info btn-xs mr-border-radius-5" title="админ/не админ"><i
                        class="fa fa-pagelines"></i></a>

                    <a href="{{ route('user_office_delete',['id'=>$user_in_office->id()]) }}"
                       class="btn btn-danger btn-xs mr-border-radius-5"
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
