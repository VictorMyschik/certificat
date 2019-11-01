@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">

    @include('Admin.layouts.page_title')

    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="card-body">
          <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
            <thead>
            <tr>
              <td class="padding-horizontal">№</td>
              <td class="padding-horizontal">UserAgent</td>
              <td class="padding-horizontal">Примечание</td>
              <td class="padding-horizontal">Удалить</td>
            </tr>
            </thead>
            <tbody>
            @foreach($bots as $item)
              <tr>
                <td class="padding-horizontal small"
                    style="max-width: 200px; word-wrap: break-word;">{{ $item->id() }}</td>
                <td class="padding-horizontal small"
                    style="max-width: 200px; word-wrap: break-word;">{{ $item->getUserAgent() }}</td>
                <td class="padding-horizontal small"
                    style="max-width: 200px; word-wrap: break-word;">{{ $item->getDescription() }}</td>
                <td class="padding-horizontal small"><a href="/admin/hardware/bot/delete/{{ $item->id() }}"
                                                        onclick="return confirm('Вы уверены?');">
                    <button type="button" class="btn btn-danger btn-sm fa da-edit mr-border-radius-5"><i
                        class="fo fa-edit"></i></button>
                  </a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!-- .animated -->


  <meta name="csrf-token" content="{{ csrf_token() }}">
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
