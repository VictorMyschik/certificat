@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/language/word/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div>
      <label>Выберите язык для редактирования <span id="LanguageID" class="mr-middle"></span>
        <select class="mr-border-radius-10 col-sm-12" name="LanguageID">
          <option value="0">[не выбрано]</option>
          @foreach($languages as $language)
            @if($word->getLanguage())
              <option selected="selected" value="{{ $language->id() }}">{{ $language->getName() }}
                ({{
                $language->getDescription() }})
              </option>
            @else
              <option value="{{ $language->id() }}">{{ $language->getName() }} ({{ $language->getDescription() }})
              </option>
            @endif
          @endforeach
        </select>
      </label>
    </div>

    <div class="">
      <label>На русском<span id="Name" class="mr-middle"></span>
        <input type="text" name="Name" autocomplete="off" value="{{ $word->getName() }}" class="mr-border-radius-10">
      </label>
    </div>

    <div class="">
      <label>На иностранном<span id="Translated" class="mr-middle"></span>
        <textarea type="text" autocomplete="off" name="Translated" class="mr-border-radius-10">{{ $word->getTranslate() }}</textarea>
      </label>
    </div>
    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>
@include('Form.BaseForm.footer')