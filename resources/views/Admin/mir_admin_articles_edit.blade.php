@extends('Admin.layouts.app')
@section('content')
  <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <div class="padding-horizontal">
      {{ Form::open(['name'=>'article_edit','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
      {{ Form::token() }}

      @include('Form.BaseForm.mr_logic_form',['form'=>$form])

      <div class="col-md-9 col-sm-12 padding-0">
        <a href="{{ route('article_list') }}" onclick="return confirm('Отменить?');" class="btn btn-xs btn-danger mr-border-radius-5 margin-t-20 margin-b-20">Вернуться</a>
        <button type="submit" class="btn btn-xs btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить
        </button>
      </div>

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
