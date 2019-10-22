<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Редактирование</title>
<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="/public/css/flaticon.css">
<link rel="stylesheet" href="/public/css/icomoon.css">
<link rel="stylesheet" href="/public/css/mr-style.css">

<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/public/vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
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
            <h1>Редактирование статьи</h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <li><a href="/admin">Главная</a></li>
              <li><a href="/admin/articles">Все статьи</a></li>
              <li class="active">статья</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 padding-horizontal">
      <div class="col-md-8 ftco-animate">
        {{ Form::open(['name'=>'edit_article','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
        {{ Form::token() }}

        <div class="margin-b-10">
          <label>Заголовок
            <input type="text" class="mr-border-radius-10 col-md-12" name="title" value="{{ $article->getTitle() }}">
          </label>
        </div>

        <div class="row col-md-12">
          <div class="col-md-3">
            <label>Спорт
              <select class="mr-border-radius-10" name="sport_kind">
                @foreach(\App\Models\MrArticle::getSportKindList() as $key => $item)
                  @if($key == $article->getSportKind())
                    <option selected
                            value="{{ $article->getSportKind() }}">{{ $article->getSportKindName() }}</option>
                  @else
                    <option value="{{ $key }}">{{ $item }}</option>
                  @endif
                @endforeach
              </select>
            </label>
          </div>
          <div class="col-md-3">
            <label>Сезон
              <select class="mr-border-radius-10" name="seoson">
                @foreach(\App\Models\MrArticle::getSeosonKindNameList() as $key => $item)
                  @if($key == $article->getSeosonKind())
                    <option selected
                            value="{{ $article->getSeosonKind() }}">{{ $article->getSeosonKindName() }}</option>
                  @else
                    <option value="{{ $key }}">{{ $item }}</option>
                  @endif
                @endforeach
              </select>
            </label>
          </div>
          <div class="col-md-3">
            <label>Просмотров<br>
              <input class="mr-border-radius-10" value="{{ $article->getCounter() }}" name="counter" maxlength="6"
                     size="5">
            </label>
          </div>
        </div>

        <div>
          <label>HashTags
            <input name="hashtags" type="text" value="{{ $article->getHashTags() }}"
                   class="mr-border-radius-10 col-md-12">
          </label>

          <script>
            $("#mr_logo").bind('change', function () {
              let max_size = 5;
              let file_size = parseInt(this.files[0].size) / 1024 / 1024;
              if (file_size > max_size)
              {
                alert('Размер файла: ' + String(file_size).substring(0, 5) + 'МБ превышает допустимый ' + max_size + 'МБ');
              }
            });
          </script>
          <input class="margin-l-20" type="file" id="mr_logo" name="mr_logo">
        </div>
        <div class="col-md-12">
          <textarea name="text" class="textarea" id="editor1" title="Contents">{{ $article->getText() }}</textarea>
        </div>
        <script>
          CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: '/elfinder/ckeditor',
            height: 500,
          });
        </script>
        <button type="submit" class="btn btn-primary mr-border-radius-10 margin-t-20">Сохранить</button>
        {!! Form::close() !!}
      </div>
    </div>


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
