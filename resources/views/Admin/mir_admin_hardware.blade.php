<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Системная информация</title>
<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
            <h1>Системная информация</h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <li><a href="/admin">Главная</a></li>
              <li class="active">HardWare</li>
            </ol>
          </div>
        </div>
      </div>
    </div>


    <div class="content mt-3">
      <div class="animated fadeIn">
        <div class="row">

          <div class="col-md-12">
            <div class="">Выделение памяти: <i id="memory" class="mr_bold">{{ $memory }}</i>
              <span class="margin-l">Пик: </span><i id="memory_pic" class="mr_bold">{{ $memory_pic }}</i>
            </div>
          </div>

        </div>
      </div><!-- .animated -->
      <hr>
    </div><!-- .content -->


    <div class="content mt-3">
      <div class="animated fadeIn">
        <div class="row">

          <div class="col-md-12">
            <a href="/admin/hardware" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">день</button>
            </a>
            <a href="/admin/hardware?date=week" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">неделя</button>
            </a>
            <a href="/admin/hardware?date=month" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
                месяц
              </button>
            </a>
            <a href="/admin/hardware?date=year" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
                год
              </button>
            </a>


            <a href="/admin/hardware?type=user" style="color: white" class="margin-l-20">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
                User
              </button>
            </a>

            <a href="/admin/hardware?type=bot" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
                Bot
              </button>
            </a>

            <a href="/admin/hardware?type=all" style="color: white">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
                Все
              </button>
            </a>

            <a href="/admin/hardware/delete" style="color: white" onclick="return confirm('Уверены?')">
              <button type="button" class="btn btn-primary btn-sm mr-border-radius-5 pull-right">
                Очистить всё
              </button>
            </a>


            <span class="margin-l-20">{!! $date !!} ({{ count($logs) }})</span>
            <div class="card-body padding-horizontal">
              <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
                <thead>
                <tr>
                  <td class="padding-horizontal">№</td>
                  <td class="padding-horizontal">Дата/время</td>
                  <td class="padding-horizontal">IP</td>
                  <td class="padding-horizontal">Источник</td>
                  <td class="padding-horizontal">URL</td>
                  <td class="padding-horizontal">Робот</td>
                  <td class="padding-horizontal">UserAgent</td>
                  <td class="padding-horizontal">Cookie</td>
                  <td class="padding-horizontal">Местоположение</td>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $item)
                  <tr>
                    <td class="padding-horizontal small"
                        style="max-width: 200px; word-wrap: break-word;">{{ $item->id() }}</td>
                    <td class="padding-horizontal small"
                        style="max-width: 200px; word-wrap: break-word;">{{ date('d M H:m:s', strtotime($item->getDate())) }}</td>
                    <td class="padding-horizontal small"
                        style="max-width: 200px; word-wrap: break-word;">{{ $item->getIp() }}</td>
                    <td class="padding-horizontal small"
                        style="max-width: 200px; word-wrap: break-word;"><a href="{{ $item->getReferer() }}" target="_blank">{{ $item->getReferer() }}</a></td>
                    <td class="padding-horizontal small"
                        style="max-width: 200px; word-wrap: break-word;"><a href="{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_URL.$item->getLink() }}" target="_blank">{{ $item->getLink() }}</a></td>
                    <td class="padding-horizontal small">{!!
                     $item->getUser()?
                     '<div>'.$item->getUser()->getName().'</div>
                      <div>'.$item->getUser()->getEmail().'</div>'
                     :($item->getBot()
                    ?
                    $item->getBot()->getDescription()
                    :
              '<button type="button" class="btn btn-primary btn-sm mr-border-radius-5" onclick="mr_edit('.$item->id().')">
                bot
              </button>')

            !!}</td>
                    <td class="padding-horizontal small">{{ $item->getUserAgent() }}</td>
                    <td class="padding-horizontal small">{{ $item->getCookie() }}</td>
                    <td class="padding-horizontal small">{{ $item->getCity() }} / {{ $item->getCountry() }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- .animated -->
    </div><!-- .content -->


  </div><!-- /#right-panel -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="/public/vendors/jquery/dist/jquery.min.js"></script>
  <script src="/public/vendors/popper.js/dist/umd/popper.min.js"></script>
  <script src="/public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="/public/js/js/main.js"></script>
  <script src="/public/js/mr_bot_edit.js"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">

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
