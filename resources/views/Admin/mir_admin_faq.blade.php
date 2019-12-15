@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="margin-b-15 margin-t-10">
      <a href="{{ route('edit_faq', ['id' =>0]) }}">
        <button type="button" title="Создать новую запись" class="btn btn-info btn-sm mr-border-radius-5">
          new FAQ
        </button>
      </a>
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td><b>Наименование</b></td>
        <td><b>#</b></td>
      </tr>
      <thead>
      <tbody>
      @foreach($list as $value)
        <tr>
          <td><a href="/admin/faq/edit/{{ $value->id() }}">{{ $value->getTitle() }}</a></td>
          <td>
            <a href="/admin/faq/edit/{{ $value->id() }}">
              <button type="button" title="Изменить"
                      class="btn btn-info btn-sm mr-border-radius-5"><i class="fa fa-edit"></i></button>
            </a>
            <a href="/admin/faq/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
              <button type="button" class="btn btn-danger btn-sm mr-border-radius-5"><i class="fa fa-trash-o"></i>
              </button>
            </a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
