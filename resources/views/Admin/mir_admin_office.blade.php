@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="margin-b-15 margin-t-10">
          {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_edit', 'Admin\\MrAdminOfficeEditForm', ['id' =>'0'], 'Создать пустой офис', ['btn btn-info btn-xs']) !!}
        </div>
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>ID</td>
            <td>Наименование</td>
            <td>Админ(ы)</td>
            <td>Тарифы</td>
            <td>Примечание</td>
            <td>#</td>
          </tr>
          <thead>
          <tbody>
          @foreach($list as $value)
            <tr>
              <td>{{ $value->id() }}</td>
              <td>{{ $value->getName() }}</td>
              <td>
                @foreach($value->GetUsers() as $admin)
                  {{ $admin->getUser()->GetFullName() }}
                @endforeach
              </td>
              <td>
                @foreach($value->GetTariffs() as $til)
                  <div>{{ $til->getTariff()->getName() }}</div>
                @endforeach
              </td>
              <td>{{ $value->getDescription() }}</td>
              <td>
                <a href="{{ route('office_page',['id'=>$value->id()]) }}"
                   class="btn btn-primary btn-xs mr-border-radius-5">
                  <i class="fa fa-eye"></i></a>
                {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('office_edit', 'Admin\\MrAdminOfficeEditForm', ['id' =>$value->id()], '', ['btn btn-info btn-xs fa fa-edit']) !!}
                <a href="/admin/office/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
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
