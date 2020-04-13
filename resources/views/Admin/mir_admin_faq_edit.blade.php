@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-b-10 m-t-10">
      @include('Admin.layouts.page_title')
      {!!  MrMessage::GetMessage() !!}
      <div class="padding-horizontal-0">
        {{ Form::open(['name'=>'edit_article','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => false]) }}
        {{ Form::token() }}
        @include('Form.BaseForm.mr_logic_form',['form'=>$form])
        <div class="col-md-12 m-b-10 m-t-10 padding-horizontal-0">
          <a href="{{ route('admin_faq_page') }}" onclick="return confirm('Отменить?');"
             class="btn btn-sm btn-danger mr-border-radius-5 margin-t-20 margin-b-20">Вернуться</a>
          <button type="submit" class="btn btn-sm btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить
          </button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
