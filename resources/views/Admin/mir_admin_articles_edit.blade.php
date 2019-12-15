@extends('layouts.app')
@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
    {!!  \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
    <div class="padding-horizontal">
      {{ Form::open(['name'=>'article_edit','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
      {{ Form::token() }}
      @include('Form.BaseForm.mr_logic_form',['form'=>$form])
      <div class="col-md-9 col-sm-12 padding-0">
        <a href="{{ route('article_list') }}" onclick="return confirm('Отменить?');"
           class="btn btn-xs btn-danger mr-border-radius-5 margin-t-20 margin-b-20">Вернуться</a>
        <button type="submit" class="btn btn-xs btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить
        </button>
      </div>
      {!! Form::close() !!}
    </div>
  </div><!-- /#right-panel -->
@endsection
