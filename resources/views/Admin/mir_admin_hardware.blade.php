@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-20 margin-t-15" style="color: white">
      <a href="/admin/hardware" style="color: white">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">день</button>
      </a>
      <a href="/admin/hardware?date=week">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">неделя</button>
      </a>
      <a href="/admin/hardware?date=month">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          месяц
        </button>
      </a>
      <a href="/admin/hardware?date=year">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          год
        </button>
      </a>


      <a href="/admin/hardware?type=user" class="margin-l-20">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          User
        </button>
      </a>

      <a href="/admin/hardware?type=bot">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          Bot
        </button>
      </a>

      <a href="/admin/hardware?type=all">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          Все
        </button>
      </a>

      <a href="/admin/hardware/delete" onclick="return confirm('Уверены?')">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5 pull-right">
          Очистить всё
        </button>
      </a>
    </div>

    <span class="margin-l-20">{!! $date !!} ({{ count($logs) }})</span>
    <div class="">
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
            <td class="padding-horizontal">{{ $item->id() }}</td>
            <td class="padding-horizontal"
                style="max-width: 200px; word-wrap: break-word;">{{ date('d M H:m:s', strtotime($item->getDate())) }}</td>
            <td class="padding-horizontal">{{ $item->getIp() }}</td>
            <td class="padding-horizontal" style="max-width: 150px; word-wrap: break-word;">
              <div class="mr-small">{{ $item->getReferer() }}</div>
              <a href="{{ $item->getReferer() }}" class="btn btn-primary btn-xs" target="_blank">Link</a>
            </td>
            <td class="padding-horizontal">
              <div class="mr-small"  style="max-width: 100px; word-wrap: break-word;">{{ $item->getLink() }}</div>
              <a href="{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_URL.$item->getLink() }}" class="btn btn-primary btn-xs">
                Link
              </a>
            </td>
            <td class="padding-horizontal">{!!
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
            <td class="padding-horizontal">{{ $item->getUserAgent() }}</td>
            <td class="padding-horizontal">{{ $item->getCookie() }}</td>
            <td class="padding-horizontal">{{ $item->getCity() }} / {{ $item->getCountry() }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
