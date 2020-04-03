@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
      <div class="mr_bold col-md-4 col-sm-12">{{ $message->getName() }} {{ $message->getEmail() }}</div>
      <div class="mr_bold col-md-4 col-sm-12">{{  date('d M Y H:i', strtotime($message->getDate())) }}</div>
      <h5>Текст:</h5>
      <div class="col-md-12">{{ $message->getText() }}</div>
      <h5>Ответ:</h5>
      <form action="/admin/feedback/edit/send/{{ $message->id() }}" method="post">
        {{ Form::token() }}
        <textarea name="text" class="textarea" id="editor1"
                  title="Contents">{{ $message->getSendMessage() }}</textarea>
        <br>
        <button type="submit" class="btn btn-primary btn-xs  mr-border-radius-5">Отправить</button>
      </form>
    </div>
  </div>
@endsection
