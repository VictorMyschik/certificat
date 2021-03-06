@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      {!! MrLink::open('admin_article_page',[],'Назад','btn btn-success btn-sm') !!}
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div class="padding-horizontal-0">
        {{ Form::open(['name'=>'article_edit','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
        {{ Form::token() }}

        @include('Form.BaseForm.mr_logic_form',['form'=>$form])

        <div class="container padding-horizontal-0">
          <a href="{{ route('admin_article_page') }}" onclick="return confirm('Отменить?');"
             class="btn btn-sm btn-danger mr-border-radius-5 m-t-20 margin-b-20">Вернуться</a>
          <button type="submit" class="btn btn-sm btn-primary mr-border-radius-5 m-t-20 m-b-20">Сохранить
          </button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
