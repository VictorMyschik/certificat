@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center"
           data-scrollax-parent="true">
        <div class="col-md-9 ftco-animate m-t-20">
          {!! $article?$article->getText():null !!}
        </div>
      </div>
    </div>
  </div>
@endsection