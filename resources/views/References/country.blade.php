@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
<div class="container">
  <div class="row justify-content-center padding-t-10">
    <h4>{{$reference_name}}</h4>
    <table class="table table-striped table-hover table-bordered mr-middle">
      <thead>
      <tr>
        <td><b>ID</b></td>
        <td><b>Континент</b></td>
        <td><b>Наименование</b></td>
        <td><b>Столица</b></td>
        <td><b>ISO-3166 alpha2</b></td>
        <td><b>ISO-3166 alpha3</b></td>
        <td><b>ISO-3166 numeric</b></td>
        <td><b>Флаг</b></td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
      <tr>
        <td>{{ $value->id() }}</td>
        <td>{{ $value->getContinentName() }}</td>
        <td>{{ $value->getName() }}</td>
        <td>{{ $value->getCapital() }}</td>
        <td>{{ $value->getISO3166alpha2() }}</td>
        <td>{{ $value->getISO3166alpha3() }}</td>
        <td>{{ $value->getISO3166numeric() }}</td>
        <td><img style="width: 30px;" title="Flag {{ $value->getName() }}" src="https://img.geonames.org/flags/m/{{ mb_strtolower($value->getISO3166alpha2()) }}.png" alt="{{ $value->getName() }}"></td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

