@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_details_form_edit', 'Admin\\MrAdminCertificateDetailsEditForm',
       ['certificate_id'=>$certificate->id(),'id' => '0'], 'Добавить',['btn btn-info btn-sm']) !!}
    </div>
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <h4 class="margin-t-10">Сертификат: {{ $certificate->GetFullName() }}</h4>
    <hr>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>ID</td>
        <td>Поле</td>
        <td>Значение</td>
        <td>Актуален</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getField() }}</td>
          <td>{{ $value->getValue() }}</td>
          <td>{{ $value->getWriteDate()->format('d.m.Y H:i:s') }}</td>
          <td>
            {!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_details_form_edit', 'Admin\\MrAdminCertificateDetailsEditForm',
            ['certificate_id'=>$certificate->id(),'id' => $value->id()], '',['btn btn-primary btn-sm fa fa-edit']) !!}
            <a href="/admin/certificate/{{ $certificate->id() }}/details/delete/{{ $value->id() }}"
               onclick="return confirm('Вы уверены?');">
              <button type="button" class="btn btn-danger btn-sm mr-border-radius-5"><i class="fa fa-trash-o"></i>
              </button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

