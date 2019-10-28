@extends('layouts.app')

@section('content')
@include('layouts.mr_nav')
<div class="container">
  <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center"
       data-scrollax-parent="true">

    <h4>{{$reference_name}}</h4>

    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td><b>ID</b></td>
        <td><b>Наименование</b></td>
        <td><b>English</b></td>
        <td><b>Код</b></td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
      <tr>
        <td>{{ $value->id() }}</td>
        <td>{{ $value->getNameRus() }}</td>
        <td>{{ $value->getNameEng() }}</td>
        <td>{{ $value->getCode() }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

