@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <table class="table table-hover table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td class="padding-horizontal">№</td>
        <td class="padding-horizontal">UserAgent</td>
        <td class="padding-horizontal">Примечание</td>
        <td class="padding-horizontal">Удалить</td>
      </tr>
      </thead>
      <tbody>
      @foreach($bots as $item)
        <tr>
          <td class="padding-horizontal"
              style="max-width: 200px; word-wrap: break-word;">{{ $item->id() }}</td>
          <td class="padding-horizontal"
              style="max-width: 200px; word-wrap: break-word;">{{ $item->getUserAgent() }}</td>
          <td class="padding-horizontal"
              style="max-width: 200px; word-wrap: break-word;">{{ $item->getDescription() }}</td>
          <td class="padding-horizontal"><a href="/admin/hardware/bot/delete/{{ $item->id() }}"
                                            onclick="return confirm('Вы уверены?');">
              <button type="button" class="btn btn-danger btn-xs fa da-edit mr-border-radius-5"><i
                    class="fo fa-edit"></i></button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
