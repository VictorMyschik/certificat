@extends('layouts.app')

@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="d-inline-block">
        <h4>Список языков <span title="Редактировать">
       {!!  MrBtn::loadForm('admin_language_edit_form', ['id' => '0'],'Добавить язык', ['btn-primary', 'btn-sm']) !!}</span>
        </h4>
        {!!  MrMessage::GetMessage() !!}
        @foreach($languages as $language)
          <span class="mr-border-radius-10 mr-language-icon" title="{{$language->getDescription()}}"
                style="border: #0d152a 1px solid;padding-left: 5px;padding-right: 5px;background-image: url('/public/images/other/bg-btn.jpg');color: #00A000;">{{$language->getName()}}</span>
        @endforeach
      </div>

      <div class="margin-b-15 m-t-10 m-b-10">
        {!! MrBtn::loadForm('translate_word_edit', ['id' => '0'], 'Добавить перевод',['btn-primary btn-sm']) !!}
      </div>
      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td class="padding-horizontal">№</td>
          <td class="padding-horizontal">Русский</td>
          <td class="padding-horizontal">Язык</td>
          <td class="padding-horizontal">Перевод</td>
          <td class="padding-horizontal">#</td>
        </tr>
        </thead>
        <tbody>
        @foreach($translate as $word)
          <tr>
            <td class="padding-horizontal">{{ $word->id() }}</td>
            <td class="padding-horizontal">{{ $word->getName() }}</td>
            <td class="padding-horizontal">{{ $word->getLanguage()->getName() }}</td>
            <td class="padding-horizontal">{{ $word->getTranslate() }}</td>
            <td class="padding-horizontal">
              {!!  MrBtn::loadForm('translate_word_edit',  ['id' => $word->id()],'',['btn-primary btn-xs fa fa-edit']) !!}
              <a href="/admin/language/word/{{$word->id()}}/delete"
                 onclick="return confirm('Уверены? Будет удален перевод {{ $word->getName() }} с {{ $word->getLanguage()->getName() }} языка.');"
                 class="btn btn-danger btn-xs fa fa-trash mr-border-radius-5">
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

