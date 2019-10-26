<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Пользователи</title>
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
            <h1>Подписка</h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <li><a href="/admin">Главная</a></li>
              <li class="active">Подписка</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="animated fadeIn">
      {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
      <div class="card-body padding-horizontal">
        <h5>Новая подписка</h5>
        {{ Form::open(['url'=>'/admin/subscription/new/','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => false]) }}
        {{ Form::token() }}
        <div class="d-inline-flex">
          <div>
            <input name="email" type="text" placeholder="Email" class="mr-border-radius-5 padding-horizontal">
          </div>
          <div>
            <button type="submit" class="btn btn-primary btn-sm mr-border-radius-5">Подписать</button>
          </div>
        </div>
        {!! Form::close() !!}
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr>
            <td class="padding-horizontal">№</td>
            <td class="padding-horizontal">Email</td>
            <td class="padding-horizontal">Дата</td>
            <td class="padding-horizontal">Del</td>
          </tr>
          </thead>
          <tbody>
          @foreach($emails as $email)
            <tr>
              <td class="padding-horizontal small">{{ $email->id() }}</td>
              <td class="padding-horizontal small">{{ $email->getEmail() }}</td>
              <td class="padding-horizontal small">{{ $email->getDate()->format('d M Y H:i') }}</td>
              <td class="padding-horizontal small">
                <a href="/admin/subscription/delete/{{ $email->id() }}"
                   onclick="return confirm('Отписать Email: {{ $email->getEmail() }} от рассылки');">Удалить</a>
              </td>
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
