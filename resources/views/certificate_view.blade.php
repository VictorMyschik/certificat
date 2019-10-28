@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
  <div class="container">
    <div class="row margin-t-20">
      <h3>Документ {{ $certificate->getKindName() }}</h3>
    </div>

    <table id="bootstrap-data-table-export" class="table table-responsive">
      <thead>
      <tr class="mr-bold">
        <td>{{ __('mr-t.Параметр') }}</td>
        <td>{{ __('mr-t.Значение') }}</td>
      </tr>
      <thead>
      <tbody>
      <tr>
        <td>{{ __('mr-t.Тип') }}</td>
        <td>{{ $certificate->getKindName() }}</td>
      </tr>
      <tr>
        <td>{{ __('mr-t.Страна') }}</td>
        <td>{{ $certificate->getCountry()->getCodeWithName() }}</td>
      </tr>
      <tr>
        <td>{{ __('mr-t.Номер') }}</td>
        <td>{{ $certificate->getNumber() }}</td>
      </tr>
      <tr>
        <td>{{ __('mr-t.Дата с') }}</td>
        <td>{{ $certificate->getDateFrom()->format('d.m.Y') }}</td>
      </tr>
      <tr>
        <td>{{ __('mr-t.Срок действия') }}</td>
        <td>{{ $certificate->getDateTo()->format('d.m.Y') }}</td>
      </tr>
      <tr>
        <td>{{ __('mr-t.Дата актуальна на') }}</td>
        <td>{{ $certificate->getWriteDate()->format('d.m.Y') }}</td>
      </tr>
      </tbody>
    </table>
  </div>
@endsection

