@extends('layouts.app')

@section('content')

  <section class="ftco-section">
    <div class="container">
      <h3><a href="/admin">Админка</a></h3>

      <table>
        <tr>
          <td><b>Наименование</b></td>
          <td>Удалить</td>
        </tr>
        @foreach($list as $value)
          <tr>
            <td><a href="/admin/faq/{{ $value->id() }}">{{ $value->getTitle() }}</a></td>
            <td><a href="/admin/faq/delete/{{ $value->id() }}">Go</a></td>
          </tr>
        @endforeach

      </table>
      <h5><a href="/admin/faq/0">Создать</a></h5>
    </div>
  </section>

@endsection