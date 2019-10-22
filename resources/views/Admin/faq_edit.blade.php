@extends('layouts.app')

@section('content')
  <section class="ftco-section">
    <div class="container">
      <div class="d-sm-inline-flex">
        <h4><a href="/admin">Админка</a></h4>
        <h4 class="margin-l-10"><a href="/admin/faq">Faq</a></h4>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      {{ Form::open(['name'=>'edit_article','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
      {{ Form::token() }}

      <div class="row col-md-12">
        <input type="text" class="mr-border-radius-10" name="title" style="width: 50%; text-align: center"
               value="{{ $faq->getTitle() }}">
      </div>
      <br>

      <div class="col-md-8">
        <textarea name="text" class="textarea" id="editor1" title="Contents">{{ $faq->getText() }}</textarea>
      </div>
      <script>
        CKEDITOR.replace( 'editor1',{
          filebrowserBrowseUrl : '/elfinder/ckeditor'
        } );
      </script>

      <br>
      <button type="submit" class="btn btn-primary">Сохранить</button>
      {!! Form::close() !!}
    </div>
  </section>



  <section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-start mb-5 pb-3">
        <div class="col-md-7 heading-section ftco-animate">
          <span class="subheading">FAQS</span>
          <h2 class="mb-4"><strong>Часто</strong> задаваемые вопросы</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 ftco-animate">
          <div id="accordion">
            @foreach($list as $value)
              <div class="row">
                <div class="card" style="width: 100%">

                  <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#menu{{ $value->id() }}" aria-expanded="true"
                       aria-controls="menu{{ $value->id() }}">{{ $value->getTitle() }}<span class="collapsed">
                        <i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
                  </div>

                  <div id="menu{{ $value->id() }}" class="collapse">
                    <div class="card-body">
                      {!!  $value->getText() !!}
                    </div>
                  </div>

                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>





@endsection