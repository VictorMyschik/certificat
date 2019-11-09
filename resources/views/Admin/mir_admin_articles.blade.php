@extends('Admin.layouts.app')

@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="margin-b-15 margin-t-10">
          <a href="{{ route('article_edit',['id'=>'0']) }}" title="Создать новую запись"
             class="btn btn-info btn-sm mr-border-radius-5">
            new
          </a>
        </div>
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
          <thead>
          <tr class="mr-bold">
            <td>Тип</td>
            <td>Язык</td>
            <td>Public</td>
            <td>#</td>
          </tr>
          <thead>
          <tbody>
          @foreach($list as $article)
            <tr>
              <td>{{ $article->getKindName() }}</td>
              <td>{{ $article->getLanguage()?$article->getLanguage()->getName():'RU' }}</td>
              <td>{!! $article->getIsPublic()?'<span class="mr-color-green">public</span>':'<span class="mr-color-red">no</span>' !!}</td>
              <td>
                <a href="{{ route('article_edit',['id'=>$article->id()]) }}" title="Создать новую запись"
                   class="btn btn-info btn-xs mr-border-radius-5">
                  <span class="fa fa-edit "></span>
                </a>
                <a href="{{ route('article_delete',['id'=>$article->id()]) }}" title="Создать новую запись"
                   class="btn btn-danger btn-xs mr-border-radius-5" onclick="return confirm('Будет удалена статья. Продолжить?');">
                  <span class="fa fa-trash-o"></span>
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