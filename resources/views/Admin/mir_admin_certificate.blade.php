@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
      <div class="card-body">
        <div class="card-body padding-horizontal">
          {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
          <div class="margin-b-15 margin-t-10">
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_form_edit', 'Admin\\MrAdminCertificateEditForm', ['id'
            =>'0'],	'Добавить сертификат',['btn btn-info btn-sm']) !!}
          </div>
          <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
            <thead>
            <tr>
              <td>ID</td>
              <td>Тип</td>
              <td>Номер</td>
              <td>Дата с</td>
              <td>Дата по</td>
              <td>Страна</td>
              <td>Статус</td>
              <td>ссылка</td>
              <td>Примечание</td>
              <td>Актуален</td>
              <td>#</td>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $certificate)
              <tr>
                <td>{{ $certificate->id() }}</td>
                <td>{{ $certificate->getKindName() }}</td>
                <td>{{ $certificate->getNumber() }}</td>
                <td>{{ $certificate->getDateFrom()->getShortDate() }}</td>
                <td>{{ $certificate->getDateTo()->getShortDate() }}</td>
                <td>{{ $certificate->getCountry()->getNameRus() }}</td>
                <td>{{ $certificate->getStatusName() }}</td>
                <td><a href="{{ $certificate->getLinkOut() }}" target="_blank">ссылка</a></td>
                <td>{{ $certificate->getDescription() }}</td>
                <td>{{ $certificate->getWriteDate()->format('d.m.Y H:i:s') }}</td>
                <td class="padding-horizontal small">
                  {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_form_edit', 'Admin\\MrAdminCertificateEditForm',
                  ['id' =>
                  $certificate->id()], '',['btn btn-info btn-sm fa fa-edit']) !!}

                  <a href="/admin/certificate/details/{{ $certificate->id() }}">
                    <button type="button" class="btn btn-primary btn-sm fa da-edit mr-border-radius-5"><span
                        class="fo fa-eye"></span></button>
                  </a>
                  <a href="/admin/certificate/delete/{{ $certificate->id() }}" onclick="return confirm('Вы уверены?');">
                    <button type="button" class="btn btn-danger btn-sm fa da-edit mr-border-radius-5"><span
                        class="fo fa-trash-o"></span></button>
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <hr>

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

