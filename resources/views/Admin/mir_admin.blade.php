@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">dw
      @include('Admin.layouts.page_title')
      <div class="card-body padding-horizontal">
        <div class="d-inline col-md-6">
          <h4 class="mr-bold">Redis</h4>
          <table>
            <tr>
              <td>Размер</td>
              <td class="padding-horizontal">{{ $Redis['used_memory'] }}</td>
            </tr>
            <tr>
              <td>Max памяти</td>
              <td class="padding-horizontal">{{ $Redis['max_memory'] }}</td>
            </tr>
            <tr>
              <td>Кол объектов</td>
              <td class="padding-horizontal">{{ $Redis['dbSize'] }}</td>
            </tr>
          </table>
        </div>
        <div class="d-inline col-md-6 border">
          <h4></h4>

        </div>
      </div>
    </div>
  </div>
@endsection
