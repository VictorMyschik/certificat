@extends('layouts.app')

@section('content')


  <section class="ftco-section bg-light">
    <div class="container">

      <div class="mr-small-bold">Memory: <i id="memory">0</i>
        <span class="margin-l">Пик: </span><i id="memory_pic">0</i>
      </div>

      <table class="table-striped table-bordered">
        <tr class="mr_bold">
	        <td class="padding-horizontal">ID</td>
          <td class="padding-horizontal">Наименование</td>
          <td class="padding-horizontal">Дата обновления</td>
          <td class="padding-horizontal">Кол. строк</td>
          <td class="padding-horizontal">Обновить</td>
          <td class="padding-horizontal">Удалить все</td>
        </tr>
        @foreach($data_all as $row)
          <tr>
	          <td class="padding-horizontal">{{ $row->id() }}</td>
            <td class="padding-horizontal">{{ $row->getTitle() }}</td>
            <td class="text-center">{{ date('H:i:s d M', strtotime($row->getDate())) }}</td>
            <td id="count_{{ $row->id() }}" class="text-center">{{ $row->getDataCount() }}</td>
            <td class="text-center"><a href="/admin/database/update/{{ $row->id() }}" class="btn btn-sm btn-primary">Update</a></td>
            <td class="text-center"><a href="/admin/database/delete/{{ $row->id() }}" class="btn btn-sm btn-danger" onclick="return confirm('Уверены?');">Delete</a></td>
          </tr>
        @endforeach
        <tr>
          <td class="text-center"></td>
          <td class="text-center">Типы отелей</td>
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td class="text-center"><a href="/admin/database/update/typehotels" class="btn btn-sm btn-primary">Update</a></td>
          <td class="text-center"><a href="/admin/database/delete/typehotels" class="btn btn-sm btn-danger" onclick="return confirm('Уверены?');">Delete</a></td>
        </tr>
      </table>
      <div class="btn btn-sm mr-color-green" onclick="startUpdate()">Go</div>
      <div class="btn btn-sm red" onclick="stopUpdate()">Stop</div>
    </div>
  </section>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="/public/js/mr_database_update_hotels.js"></script>
@endsection