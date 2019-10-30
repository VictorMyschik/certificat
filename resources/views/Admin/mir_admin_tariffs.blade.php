<title>{{ $page_title }}</title>
<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="/public/vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">
<link rel="stylesheet" href="/public/css/mr-style.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <h1>{{ $page_title }}
            {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('tariff_edit', 'Admin\\MrUserEditForm', ['id' => '0'], 'Новый',['btn btn-info btn-sm']) !!}
          </h1>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <ol class="breadcrumb text-right">
            <li><a href="/admin">Главная</a></li>
            <li class="active">{{ $page_title }}</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td>ID</td>
            <td>Наименование</td>
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
              <td>{{ $value->getMeasure() }}</td>
              <td>{{ $value->getCost() }}</td>
              <td>{{ $value->getDescription() }}</td>
              <td>
                <a href="/admin/tariff/edit/{{ $value->id() }}">
                  <button type="button" title="Изменить"
                          class="btn btn-info btn-sm mr-border-radius-5"><i class="fa fa-edit"></i></button>
                </a>
                <a href="/admin/tariff/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
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
