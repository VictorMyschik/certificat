@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      <a href="{{ route('admin_faq_edit', ['id' =>0]) }}" title="Создать новую запись" class="btn btn-primary btn-sm mr-border-radius-5">new FAQ</a>
    </div>
    <table class="table table-hover table-striped table-bordered mr-middle">
      <thead>
      <tr class="mr-bold">
        <td><b>Наименование</b></td>
        <td><b>#</b></td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td><a href="/admin/faq/edit/{{ $value->id() }}">{{ $value->getTitle() }}</a></td>
          <td>
            <a href="{{ route('admin_faq_edit',['id'=>$value->id()]) }}"
               class="btn btn-primary btn-xs mr-border-radius-5 fa fa-edit"></a>
            <a href="{{ route('admin_faq_delete',['id'=>$value->id()]) }}" onclick="return confirm('Вы уверены?');"
               class="btn btn-danger btn-xs mr-border-radius-5 fa fa-trash-alt"></a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
