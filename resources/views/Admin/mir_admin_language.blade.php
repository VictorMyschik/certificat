<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Версии сайта на разных языках</title>
<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="/public/css/mr-style.css">
@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <h1>Страница управления языками</h1>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <ol class="breadcrumb text-right">
            <li><a href="/admin">Главная</a></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content mt-3">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body margin-t-15">
              <div class="row col-md-12 d-inline-block">
                <h4>Список языков
                  <span
                    title="Редактировать">{!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_language_edit_form', "Admin\\MrLanguageEditForm", ['id' => '0'],'Добавить',['btn btn-info btn-sm']) !!}</span>
                </h4>
                {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
                @foreach($languages as $language)
                  <span class="mr-border-radius-10 mr-language-icon" title="{{$language->getDescription()}}"
                        style="border: #0d152a 1px solid;padding-left: 5px;padding-right: 5px;background-image: url('/public/images/other/bg-btn.jpg');color: #00A000;">{{$language->getName()}}</span>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <hr>
      </div><!-- .animated -->
    </div><!-- .content -->
    <div class="content mt-3">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <h4>
                {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('translate_word_edit', 'Admin\\MrTranslateWordEditForm', ['id' => '0'], 'Добавить перевод',['btn btn-primary btn-sm']) !!}
              </h4>
              <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <td class="padding-horizontal">№</td>
                  <td class="padding-horizontal">Русский</td>
                  <td class="padding-horizontal">Язык</td>
                  <td class="padding-horizontal">Перевод</td>
                  <td class="padding-horizontal">#</td>
                </tr>
                </thead>
                <tbody>
                @foreach($translate as $word)
                  <tr>
                    <td class="padding-horizontal small">{{ $word->id() }}</td>
                    <td class="padding-horizontal small">{{ $word->getName() }}</td>
                    <td class="padding-horizontal small">{{ $word->getLanguage()->getName() }}</td>
                    <td class="padding-horizontal small">{{ $word->getTranslate() }}</td>
                    <td class="padding-horizontal small">
                      {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('translate_word_edit', 'Admin\\MrTranslateWordEditForm', ['id' => $word->id()],'',['btn btn-info btn-sm fa fa-edit']) !!}

                      <a href="/admin/language/word/{{$word->id()}}/delete"
                         onclick="return confirm('Уверены? Будет удален перевод {{ $word->getName() }} с {{ $word->getLanguage()->getName() }} языка.');">
                        <button type="button" class="btn btn-danger btn-sm fa fa-trash mr-border-radius-5"></button>
                      </a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- .animated -->
      <hr>
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

