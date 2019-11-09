@extends('layouts.app')

@section('content')
  @include('Office.mr_nav_user')
  <div class="container col-md-9 col-sm-12">

    <table class="border">
      <thead>
      <tr>
        <td>ID</td>
        <td>Номер</td>
        <td>Дата с</td>
        <td>Дата по</td>
        <td>Статус</td>
        <td>Пользователь</td>
        <td>#</td>

      </tr>
      </thead>
      <tbody>
      @foreach($monitoring_list as $certificate)
        <tr>
          <td>{{ $certificate->id }}</td>
          <td>{{ $certificate->Number }}</td>
          <td>{{ $certificate->DateFrom }}</td>
          <td>{{ $certificate->DateTo }}</td>
          <td>{{ $certificate->Status }}</td>
          <td>{{ $certificate->Status }}</td>
          <td></td>
          <td></td>
        </tr>
      @endforeach
      </tbody>
    </table>


  </div>
  <div class="modal fade" id="mr_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body"></div>
      </div>
    </div>
  </div>
@endsection
