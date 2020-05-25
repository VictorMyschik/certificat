@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      {{Form::open(array('url' => '/test', 'files' => true))}}
      @csrf
      <label class="mr-bold">Очистить таблицы перед импортом
        <input type="checkbox" name="clear" value="1">
      </label>
      <table>
        @foreach($file_name as $name)
          <tr>
            <td><input type="radio" name="file_name" value="{{$name}}"></td>
            <td>{{$name}}</td>
          </tr>
        @endforeach
      </table>

      {{Form::submit('Click Me!')}}
      {{ Form::close() }}
    </div>
  </div>
@endsection

