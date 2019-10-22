@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12 margin-t-20">
      <h3><b>Регламент</b></h3>
      <h4><b>{{ $game->getTitle() }}</b></h4>
      <h5><u>Дата проведения: {{ $game->getDateStart()?$game->getDateStart()->format('d.m.y'):'' }}</u></h5>
    </div>
    <hr>
    <div class="col-md-12">
      @if($game->getConditions())
        {!! $game->getConditions() !!}
      @else
        <p class="mr-color-red mr-bold">Регламент скоро будет опубликован.</p>
      @endif
    </div>

  </div>
@endsection