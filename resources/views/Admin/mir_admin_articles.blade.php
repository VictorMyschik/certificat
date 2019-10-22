<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Статьи</title>
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

    <!-- Header-->
    <header id="header" class="header">
      <div class="header-menu">
        <div class="col-sm-7">
          <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
          <div class="header-left">
            <button class="search-trigger"><i class="fa fa-search"></i></button>
            <div class="form-inline">
              <form class="search-form">
                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
              </form>
            </div>
            <div class="dropdown for-notification">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="count bg-danger">5</span>
              </button>
              <div class="dropdown-menu" aria-labelledby="notification">
                <p class="red">You have 3 Notification</p>
                <a class="dropdown-item media bg-flat-color-1" href="#">
                  <i class="fa fa-check"></i>
                  <p>Server #1 overloaded.</p>
                </a>
                <a class="dropdown-item media bg-flat-color-4" href="#">
                  <i class="fa fa-info"></i>
                  <p>Server #2 overloaded.</p>
                </a>
                <a class="dropdown-item media bg-flat-color-5" href="#">
                  <i class="fa fa-warning"></i>
                  <p>Server #3 overloaded.</p>
                </a>
              </div>
            </div>
            <div class="dropdown for-message">
              <button class="btn btn-secondary dropdown-toggle" type="button"
                      id="message"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-email"></i>
                <span class="count bg-primary">9</span>
              </button>
              <div class="dropdown-menu" aria-labelledby="message">
                <p class="red">You have 4 Mails</p>
                <a class="dropdown-item media bg-flat-color-1" href="#">
                  <span class="message media-body">
                                    <span class="name float-left">Jonathan Smith</span>
                                    <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                </span>
                </a>
                <a class="dropdown-item media bg-flat-color-4" href="#">
                  <span class="message media-body">
                                    <span class="name float-left">Jack Sanders</span>
                                    <span class="time float-right">5 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                </span>
                </a>
                <a class="dropdown-item media bg-flat-color-5" href="#">
                  <span class="message media-body">
                                    <span class="name float-left">Cheryl Wheeler</span>
                                    <span class="time float-right">10 minutes ago</span>
                                        <p>Hello, this is an example msg</p>
                                </span>
                </a>
                <a class="dropdown-item media bg-flat-color-3" href="#">
                  <span class="message media-body">
                                    <span class="name float-left">Rachel Santos</span>
                                    <span class="time float-right">15 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                </span>
                </a>
              </div>
            </div>
            <div class="dropdown">
              <div id="clock" class="font-weight-bold margin-l-20">
                <span class="hour"></span>:<span class="min"></span>:<span class="sec"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
          <div class="user-area dropdown float-right">
            <div class="btn-group">
              <a href="/admin" class="" title="Войти в кабинет">
                <b style="color: #383838">{{ Auth::user()->name }}</b></a>
              <a href="{{ route('logout') }}" class="margin-l-20"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </header><!-- /header -->

    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Статьи
              <a href="/admin/article/edit/0">
                <button type="button" title="Создать новую запись" class="btn btn-primary btn-sm mr-border-radius-10">new</button>
              </a>
            </h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <li><a href="/admin">Главная</a></li>
              <li class="active">Статьи</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        <div class="row">

          <div class="col-md-12">
            <div class="card-body">
              <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Наименование</th>
                  <th>Создано</th>
                  <th>Просмотров</th>
                  <th>Хэш Теги</th>
                  <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $value)
                  <tr>
                    <td class="padding-horizontal small">{{ $value->id() }}</td>
                    <td class="padding-horizontal small font-weight-bold"><a
                          href="/admin/article/edit/{{ $value->id() }}">{{ $value->getTitle() }}</a></td>
                    <td class="padding-horizontal small">{{ date('d M Y', strtotime($value->getDate())) }}</td>
                    <td class="padding-horizontal small">{{ $value->getCounter() }}</td>
                    <td class="padding-horizontal small">
                      @foreach(explode('|',$value->GetHashTags()) as $tag)
                        {{ $tag?$tag:'' }}
                      @endforeach
                    </td>
                    <td><a href="/admin/faq/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');"><button type="button" class="btn btn-danger btn-sm fa da-edit mr-border-radius-5"><i class="fa fa-trash-o"></i></button></a></td>
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
