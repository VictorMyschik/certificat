@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
        <div class="margin-b-15 margin-t-10">
          {{ Form::open(['url'=>'/admin/subscription/new/','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => false]) }}
          {{ Form::token() }}
          <label>
            <input name="email" type="text" required placeholder="Email" class="mr-border-radius-5 padding-horizontal">
          </label>
          <button type="submit" class="btn btn-primary btn-xs mr-border-radius-5">Подписать</button>
          {!! Form::close() !!}
        </div>

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
                   onclick="return confirm('Отписать Email: {{ $email->getEmail() }} от рассылки');"><button type="button" class="btn btn-danger btn-xs mr-border-radius-5">Отписать</button></a>
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
