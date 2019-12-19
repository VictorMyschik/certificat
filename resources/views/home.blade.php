@extends('layouts.app')

@section('content')
  <div class="mr-bg-img">
    @include('layouts.mr_nav')


    <div class="container padding-t-20">
      <div>
        <h1 class="mr-bold">Работаете с сертификатами?</h1>

        <h3 class="mr-bold">On-line</h3>

        <h4 class="mr-bold">Библиотека актуальных декларации о соответствии</h4>
        <div class="row">
          <div class="col-md-6 margin-t-20">
            {{ Form::open(['name'=>'blog','method' => 'POST', 'files' => false]) }}
            @csrf
            <div class="input-group col-md-12">
              <input class="form-control py-2 mr-bg-index-form"
                     name='search' value=''
                     id="search" required
                     type="search" placeholder="{{ __('mr-t.Поиск сертификата') }}">
            </div>
            {!! Form::close() !!}
            <ul id="resSearch" class="margin-t-10 col-md-12"></ul>
            <script type="text/javascript">
              $(function () {
                $("#search").keyup(function () {
                  var search = $("#search").val();
                  $.ajax({
                    type: "POST",
                    url: "/search",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {"search": search},
                    cache: false,
                    success: function (response) {
                      let text_out = '';
                      for (let key in response) {
                        text_out += '<div class="mr-bg-founded padding-horizontal border border-dark mr-border-radius-5 "><a class="mr-color-dark-blue" href="/certificate/' + key + '">' + response[key] + '</div>';
                      }
                      $("#resSearch").html(text_out);
                    }
                  });
                  return false;

                })
              })

            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

