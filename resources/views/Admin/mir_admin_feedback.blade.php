@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>№</td>
            <td>Имя</td>
            <td>Email</td>
            <td>Дата</td>
            <td>Отвечена</td>
            <td>Удалить</td>
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
                <a href="/admin/feedback/edit/{{ $value->id }}">
                  <button type="button" class="btn btn-info btn-sm mr-border-radius-5"><i class="fa fa-eye"></i>
                  </button>
                </a>
                <a href="/admin/feedback/delete/{{ $value->id() }}" onclick="return confirm('Уверены?');">
                  <button type="button" class="btn btn-danger btn-sm mr-border-radius-5"><i class="fa fa-trash-o"></i>
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
