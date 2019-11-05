@extends('Admin.layouts.app')
@section('content')
  <div id="right-panel" class="right-panel">
    @include('Admin.layouts.page_title')
    <div class="animated fadeIn">
      <div class="card-body padding-horizontal">
        <div class="margin-b-20 margin-t-15" style="color: white">
          <a href="/admin/hardware" style="color: white">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">день</button>
          </a>
          <a href="/admin/hardware?date=week">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">неделя</button>
          </a>
          <a href="/admin/hardware?date=month">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">
              месяц
            </button>
          </a>
          <a href="/admin/hardware?date=year">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">
              год
            </button>
          </a>


          <a href="/admin/hardware?type=user" class="margin-l-20">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">
              User
            </button>
          </a>

          <a href="/admin/hardware?type=bot">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">
              Bot
            </button>
          </a>

          <a href="/admin/hardware?type=all">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5">
              Все
            </button>
          </a>

          <a href="/admin/hardware/delete" onclick="return confirm('Уверены?')">
            <button type="button" class="btn btn-primary btn-xs mr-border-radius-5 pull-right">
              Очистить всё
            </button>
          </a>
        </div>

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
                <td class="padding-horizontal"
                    style="max-width: 200px; word-wrap: break-word;">{{ $item->id() }}</td>
                <td class="padding-horizontal"
                    style="max-width: 200px; word-wrap: break-word;">{{ date('d M H:m:s', strtotime($item->getDate())) }}</td>
                <td class="padding-horizontal"
                    style="max-width: 200px; word-wrap: break-word;">{{ $item->getIp() }}</td>
                <td class="padding-horizontal"
                    style="max-width: 200px; word-wrap: break-word;"><a href="{{ $item->getReferer() }}"
                                                                        target="_blank">{{ $item->getReferer() }}</a>
                </td>
                <td class="padding-horizontal"
                    style="max-width: 200px; word-wrap: break-word;"><a
                    href="{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_URL.$item->getLink() }}"
                    target="_blank">{{ $item->getLink() }}</a></td>
                <td class="padding-horizontal">{!!
                     $item->getUser()?
                     '<div>'.$item->getUser()->getName().'</div>
                      <div>'.$item->getUser()->getEmail().'</div>'
                     :($item->getBot()
                    ?
                    $item->getBot()->getDescription()
                    :
              '<button type="button" class="btn btn-primary btn-xs mr-border-radius-5" onclick="mr_edit('.$item->id().')">
                bot
              </button>')
            !!}</td>
                <td class="padding-horizontal">{{ $item->getUserAgent() }}</td>
                <td class="padding-horizontal">{{ $item->getCookie() }}</td>
                <td class="padding-horizontal">{{ $item->getCity() }} / {{ $item->getCountry() }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!-- .animated -->

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
