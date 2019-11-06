@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="card-body">
      <div class="card-body padding-horizontal">
        {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="margin-b-15 margin-t-10">
          <a class="btn btn-primary btn-xs mr-border-radius-5"
             href="{{route('artisan_migrate')}}">Запустить миграцию</a>
          <p><i>Будут созданы из файлов таблицы, отсутствующие в БД</i></p>
          <div class="mr-color-red">Кнопки Back Up и Recovery пока находятся в стадии разработки</div>
        </div>
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>Таблица</td>
            <td>Миграции</td>
            <td>Данные</td>
            <td>#</td>
          </tr>
          </thead>
          <tbody>
          @foreach($list as $table)
            <tr>
              <td>{{ $table['Name'] }}</td>

              <td><a class="btn btn-danger btn-xs mr-border-radius-5"
                     onclick="return confirm('Будет переустановлена таблица! Данные будут утеряны! Продолжить?');"
                     href="{{route('migration_refresh_table', ['table_name'=>$table['Name']])}}">refresh</a></td>

              <td>{{$table['count_rows']}}</td>

              <td>
                <a class="btn btn-info btn-xs mr-border-radius-5"
                   href="{{route('save_table_data', ['table_name'=>$table['Name']])}}">Back UP</a>
                <a class="btn btn-primary btn-xs mr-border-radius-5"
                   href="{{route('recovery_table_data', ['table_name'=>$table['Name']])}}">Recovery</a>
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

