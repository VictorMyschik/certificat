@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      <a class="btn btn-primary btn-sm mr-border-radius-5"
         href="{{route('artisan_migrate')}}">Запустить миграцию</a>
      <p><i>Будут созданы из файлов таблицы, отсутствующие в БД</i></p>
      <div class="mr-color-red">Кнопки Back Up и Recovery пока находятся в стадии разработки</div>
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td>Таблица</td>
        <td>Миграции</td>
        <td>Данные</td>
        <td>#</td>
      </tr>
      </thead>
      <tbody>
      @foreach($list as $table)
        <tr>
          <td>{{ $table['Name'] }}</td>

          <td><a class="btn btn-danger btn-sm mr-border-radius-5"
                 onclick="return confirm('Будет переустановлена таблица! Данные будут утеряны! Продолжить?');"
                 href="{{route('migration_refresh_table', ['table_name'=>$table['FileName']])}}">refresh</a></td>

          <td>{{$table['count_rows']}}</td>

          <td>
            <a class="btn btn-info btn-sm mr-border-radius-5"
               href="{{route('save_table_data', ['table_name'=>$table['Name']])}}">Back UP</a>
            <a class="btn btn-info btn-sm mr-border-radius-5"
               href="{{route('recovery_table_data', ['table_name'=>$table['Name']])}}">Recovery</a>
            {!! $table['has'] ? 'да':'нет' !!}
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

