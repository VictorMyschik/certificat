@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div class="padding-horizontal">
        {{ Form::open(['name'=>'article_edit','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
        {{ Form::token() }}
        @include('Form.BaseForm.mr_logic_form',['form'=>$form])
        <div class="col-md-9 col-sm-12 padding-0">
          <a href="{{ route('admin_article_page') }}" onclick="return confirm('Отменить?');"
             class="btn btn-xs btn-danger mr-border-radius-5 margin-t-20 margin-b-20">Вернуться</a>
          <button type="submit" class="btn btn-xs btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить
          </button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
