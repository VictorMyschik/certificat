@extends('Admin.layouts.app')
@section('content')
  <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
  <div id="right-panel" class="right-panel">

    @include('Admin.layouts.page_title')

    <div class="padding-horizontal">
      {{ Form::open(['name'=>'edit_article','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
      {{ Form::token() }}

      <div class="margin-b-20 margin-t-15">
        <div class="mr-bold">Заголовок</div>
        <input type="text" class="mr-border-radius-5 col-md-6" name="title" value="{{ $faq->getTitle() }}">
      </div>

      <div class="col-md-9 col-sm-12 padding-0">
        <b>Текст ответа</b>
        <textarea name="text" class="textarea" id="editor1" title="Contents">{{ $faq->getText() }}</textarea>
        <button type="submit" class="btn btn-xs btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить
        </button>
      </div>

      <script>
          CKEDITOR.replace('editor1', {
              filebrowserBrowseUrl: '/elfinder/ckeditor'
          });
      </script>
      {!! Form::close() !!}
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
