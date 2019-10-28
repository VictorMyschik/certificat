@extends('layouts.app')

@section('content')
  @include('layouts.mr_nav')
  <div class="container">
    <div class="row justify-content-center"><h4>Справочники</h4></div>
		{!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
		<div class="row">
      <ul>
        @foreach($list as $key => $item)
          <li><a href="/reference/{{ $key }}">{{ $item }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection

