@extends('layouts.app')

@section('content')
    @include('layouts.mr_nav')
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center"
             data-scrollax-parent="true">
            <div class="col-md-9 ftco-animate text-center">
                <h3>
                    Такой страницы не существует.
                </h3>
                <h3>
                    Если Вы уверены, что она должна быть, то <a href="/faq">сообщите</a> нам.
                </h3>
            </div>
        </div>
    </div>
@endsection

