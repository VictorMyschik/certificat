@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="margin-b-15 margin-t-10">
          {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('tariff_edit', 'Admin\\MrAdminTariffEditForm', ['id' => '0'], 'Новый тариф',['btn btn-info btn-xs']) !!}
        </div>
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>ID</td>
            <td>Наименование</td>
            <td>Категория</td>
            <td>Измерение</td>
            <td>Цена</td>
            <td>Примечание</td>
            <td>#</td>
          </tr>
          <thead>
          <tbody>
          @foreach($list as $value)
            <tr>
              <td>{{ $value->id() }}</td>
              <td>{{ $value->getName() }}</td>
              <td>{{ $value->getCategoryName() }}</td>
              <td>{{ $value->getMeasureName() }}</td>
              <td>{{ $value->getCost() }}</td>
              <td>{{ $value->getDescription() }}</td>
              <td>
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('tariff_edit', 'Admin\\MrAdminTariffEditForm', ['id' => $value->id()], '',['btn btn-info btn-xs fa fa-edit']) !!}
                <a href="/admin/tariff/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
                  <button type="button" class="btn btn-danger btn-xs mr-border-radius-5"><i class="fa fa-trash-o"></i>
                  </button>
                </a></td>
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
