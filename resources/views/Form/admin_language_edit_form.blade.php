@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/language/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div>
      <label>Выберите язык для редактирования
        <select class="mr-border-radius-10 col-sm-12" name="id">
          <option value=0>[новый]</option>
          @foreach($languages as $language)
            <option value="{{ $language->id() }}">{{ $language->getName() }} ({{ $language->getDescription() }})
            </option>
          @endforeach
        </select>
      </label>
    </div>

    <div><span id="option"></span>
      <label>
        <input type="radio" name="option" value="1" checked>Изменить
      </label>
      <label class="margin-l-10">
        <input type="radio" name="option" value="2">Удалить
      </label>
    </div>

    <div>
      <label>Имя языка<span id="Name"></span>
        <input type="text" name="Name" class="mr-border-radius-10 col-sm-12">
      </label>
    </div>

    <div>
      <label>Примечание (для себя)<span id="Description"></span>
        <input type="text" name="Description" class="mr-border-radius-10 col-sm-12">
      </label>
    </div>

    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>

@include('Form.BaseForm.footer')