@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      <a href="{{ route('delete_bd_log', ['id' =>0]) }}" onclick="return confirm('Вы уверены?');">
        <button type="button" class="btn btn-danger btn-sm mr-border-radius-5">all delete</button>
      </a>
    </div>
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <table class="table table-hover table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td>ID</td>
        <td>LogIdentID</td>
        <td>RowId</td>
        <td>TableName</td>
        <td>Field</td>
        <td>Value</td>
        <td>WriteDate</td>
        <td>#</td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td>{{ $value->id() }}</td>
          <td>{{ $value->getLogIdent() ? ('ID'.$value->getLogIdent()->id()) : null }}</td>
          <td>{{ $value->getRowId() }}</td>
          <td>{{ $value->getTableName() }}</td>
          <td>{{ $value->getField() }}</td>
          <td>{{ $value->getValue() }}</td>
          <td>{{ $value->getWriteDate() }}</td>
          <td>
            <a href="/admin/hardware/dblog/delete/{{$value->id()}}" class="btn btn-danger btn-sm mr-border-radius-5"><i class=" fa fa-trash"></i></a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
