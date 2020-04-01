@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container col-md-9 col-sm-12 m-t-10">
      <div class="row padding-horizontal">

        <div class="col-md-6 padding-0">
          <h4>Работа с сертификатами</h4>
          <div class="">
            <input class="col-md-10 mr-border-radius-10 padding-horizontal"
                   style="padding-top: 2px; padding-bottom: 2px; line-height: 10px;" name='search' value='' id="search"
                   required
                   type="search" placeholder="{{ __('mr-t.Поиск сертификата') }}">
          </div>
          <ul id="resSearch" class="margin-t-5 col-md-12"></ul>
          <h5>Краткая информация</h5>
        </div>

        <div class="col-md-6 padding-0">
          <div id="accordion">

            <a data-toggle="collapse" href="#menu_1" aria-controls="menu_1">
              <div class="mr-color-black margin-t-5 mr-border-radius-10 mr-bold padding_all_0 mr-bg-footer col-md-12">
                Недавно искали
              </div>
            </a>

            <div id="menu_1" class="collapse padding-horizontal mr-middle">
            </div>
          </div>
        </div>
      </div>


    </div>

    <div class="modal fade" id="mr_modal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
  </div>
  <script src="/public/js/mr_live_search.js"></script>
@endsection
