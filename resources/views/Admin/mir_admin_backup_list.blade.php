@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    {!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <div class="margin-b-15 margin-t-10">
      <a class="btn btn-primary btn-sm mr-border-radius-5"
         href="{{route('artisan_migrate')}}">Запустить миграцию</a>
      <p><i class="fa fa-info-circle mr-color-green"></i>Будут созданы таблицы из файлов, отсутствующие в БД</p>
      <div><i class="fa fa-info-circle mr-color-green"></i>Кнопка <a class="btn btn-primary btn-xs mr-border-radius-5"
                                                                     href="#">Recovery</a> восстановит данные</div>
      <div><i class="fa fa-info-circle mr-color-green"></i>Кнопка
        <a class="btn btn-danger btn-xs mr-border-radius-5" href="#">Refresh</a> пересоздаст таблицу из кода PHP. Все данные будут <span class="mr-color-red">удалены</span>.
      </div>
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
        <td>№</td>
        <td>Таблица</td>
        <td>Миграции</td>
        <td>Данные</td>
        <td>#</td>
      </tr>
      </thead>
      <tbody>
      @foreach($list as $key => $table)
        <tr>
          <td>{{ ++$key }}</td>
          <td>{{ $table['Name'] }}</td>

          <td><a class="btn btn-danger btn-xs mr-border-radius-5"
                 onclick="return confirm('Будет переустановлена таблица! Данные будут утеряны! Продолжить?');"
                 href="{{route('migration_refresh_table', ['table_name'=>$table['FileName']])}}">Refresh</a></td>

          <td>{{$table['count_rows']}}</td>

          <td>
          <!--<a class="btn btn-info btn-sm mr-border-radius-5"
               href="{{route('save_table_data', ['table_name'=>$table['Name']])}}">Back UP</a>-->

            @if($table['has'])
              <a class="btn btn-primary btn-xs mr-border-radius-5"
                 href="{{route('recovery_table_data', ['table_name'=>$table['Name']])}}">Recovery</a>
            @endif
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

