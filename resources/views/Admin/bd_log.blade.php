<title>Лог БД</title>
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
        <div class="page-title">
          <h1>Лог БД</h1>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="page-header float-right">
        <div class="page-title">
          <ol class="breadcrumb text-right">
            <li><a href="/admin">Главная</a></li>
            <li class="active">Лог БД</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="animated fadeIn">
    <div class="card-body padding-horizontal">
      <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
        <thead>
        <tr>
          <td>ID</td>
          <td>LogIdentID</td>
          <td>RowId</td>
          <td>TableName</td>
          <td>Field</td>
          <td>Value</td>
          <td>WriteDate</td>
          <td>#</td>
        </tr>
        <thead>
        <tbody>
        @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getLogIdent()->id() }}</td>
          <td>{{ $value->getRowId() }}</td>
          <td>{{ $value->getTableName() }}</td>
          <td>{{ $value->getField() }}</td>
          <td>{{ $value->getValue() }}</td>
          <td>{{ $value->getWriteDate() }}</td>
          <td>
           </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

  </div><!-- .animated -->


</div><!-- /#right-panel -->
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
