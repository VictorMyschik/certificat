@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    @include('Admin.layouts.page_title')
    <div class="d-inline-block">
      <h4>Список языков <span title="Редактировать">
       {!!  MrBtn::loadForm('admin_language_edit_form', "Admin\\MrAdminLanguageEditForm", ['id' => '0'],'Добавить язык', ['btn-primary', 'btn-sm']) !!}</span>
      </h4>
      {!!  MrMessage::GetMessage() !!}
      @foreach($languages as $language)
        <span class="mr-border-radius-10 mr-language-icon" title="{{$language->getDescription()}}"
              style="border: #0d152a 1px solid;padding-left: 5px;padding-right: 5px;background-image: url('/public/images/other/bg-btn.jpg');color: #00A000;">{{$language->getName()}}</span>
      @endforeach
    </div>

    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('translate_word_edit', 'Admin\\MrAdminTranslateWordEditForm', ['id' => '0'], 'Добавить перевод',['btn-primary btn-sm']) !!}
    </div>
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
      <thead>
      <tr>
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
            {!!  MrBtn::loadForm('translate_word_edit', 'Admin\\MrAdminTranslateWordEditForm', ['id' => $word->id()],'',['btn-info btn-sm fa fa-edit']) !!}
            <a href="/admin/language/word/{{$word->id()}}/delete"
               onclick="return confirm('Уверены? Будет удален перевод {{ $word->getName() }} с {{ $word->getLanguage()->getName() }} языка.');">
              <button type="button" class="btn btn-danger btn-sm fa fa-trash mr-border-radius-5"></button>
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

