@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_form_edit', 'Admin\\MrAdminCertificateEditForm', ['id'=>'0'], 'Добавить сертификат',['btn btn-info btn-sm']) !!}
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>ID</td>
        <td>Тип</td>
        <td>Номер</td>
        <td>Дата с</td>
        <td>Дата по</td>
        <td>Страна</td>
        <td>Статус</td>
        <td>ссылка</td>
        <td>Примечание</td>
        <td>Актуален</td>
        <td>#</td>
      </tr>
      </thead>
      <tbody>
      @foreach($list as $certificate)
        <tr>
          <td>{{ $certificate->id() }}</td>
          <td>{{ $certificate->getKindName() }}</td>
          <td>{{ $certificate->getNumber() }}</td>
          <td>{{ $certificate->getDateFrom()->getShortDate() }}</td>
          <td>{{ $certificate->getDateTo()?$certificate->getDateTo()->getShortDate():null }}</td>
          <td>{{ $certificate->getCountry()->getNameRus() }}</td>
          <td>{{ $certificate->getStatusName() }}</td>
          <td><a href="{{ $certificate->getLinkOut() }}" target="_blank">ссылка</a></td>
          <td>{{ $certificate->getDescription() }}</td>
          <td>{{ $certificate->getWriteDate()->format('d.m.Y H:i:s') }}</td>
          <td>
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_form_edit', 'Admin\\MrAdminCertificateEditForm',
            ['id' => $certificate->id()], '',['btn btn-info btn-sm fa fa-edit']) !!}

            <a href="/admin/certificate/details/{{ $certificate->id() }}"
               class="btn btn-primary btn-sm fa fa-eye mr-border-radius-5"></a>
            <a class="btn btn-danger btn-sm mr-border-radius-5" onclick="return confirm('Вы уверены?');" href="/admin/certificate/delete/{{ $certificate->id() }}"><i class=" fa fa-trash"></i>
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

