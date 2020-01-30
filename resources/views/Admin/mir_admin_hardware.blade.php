@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-20 margin-t-15">
      <a href="/admin/system" style="color: white">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">день</button>
      </a>
      <a href="/admin/system?date=week">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">неделя</button>
      </a>
      <a href="/admin/system?date=month">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          месяц
        </button>
      </a>
      <a href="/admin/system?date=year">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5">
          год
        </button>
      </a>


      <a href="/admin/system/delete" onclick="return confirm('Уверены?')">
        <button type="button" class="btn btn-primary btn-sm mr-border-radius-5 pull-right">
          Очистить всё
        </button>
      </a>
    </div>

    <span class="margin-l-20">{!! $date !!} ({{ count($logs) }})</span>
    <div class="">
      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
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
              <a href="{{ $item->getReferer() }}" target="_blank">{{ $item->getReferer() }}</a>
            </td>
            <td class="padding-horizontal"><a href="{{ MrBaseHelper::MR_SITE_URL.$item->getLink() }}" class="">{{ $item->getLink() }}</a></td>
            <td class="padding-horizontal">{!!
                     $item->getUser()?
                     '<div>'.$item->getUser()->getName().'</div>
                      <div>'.$item->getUser()->getEmail().'</div>'
                     : null
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
