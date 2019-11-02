@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">

    @include('Admin.layouts.page_title')

    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="card-body margin-t-15">
          <div class="d-inline-block">
            <h4>Список языков <span title="Редактировать">
                    {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_language_edit_form', "Admin\\MrAdminLanguageEditForm", ['id' => '0'],'Добавить язык',['btn btn-info btn-xs']) !!}</span>
            </h4>
            {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
            @foreach($languages as $language)
              <span class="mr-border-radius-10 mr-language-icon" title="{{$language->getDescription()}}"
                    style="border: #0d152a 1px solid;padding-left: 5px;padding-right: 5px;background-image: url('/public/images/other/bg-btn.jpg');color: #00A000;">{{$language->getName()}}</span>
            @endforeach
          </div>
        </div>
      </div>
    </div><!-- .animated -->

    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="margin-b-15 margin-t-10">
          {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('translate_word_edit', 'Admin\\MrAdminTranslateWordEditForm', ['id' => '0'], 'Добавить перевод',['btn btn-primary btn-xs']) !!}
        </div>
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
                {!!  \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('translate_word_edit', 'Admin\\MrAdminTranslateWordEditForm', ['id' => $word->id()],'',['btn btn-info btn-sm fa fa-edit']) !!}

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

