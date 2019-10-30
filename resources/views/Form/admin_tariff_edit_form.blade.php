@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/tariff/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="margin-b-20">
      <h4>Сертификат: {{ $tariff?$tariff->GetFullName():null }}</h4>
    </div>

    <div>
      <label>Выберите язык для редактирования <span id="LanguageID" class="mr-middle"></span>
        <select class="mr-border-radius-10 col-sm-12" name="LanguageID">
         @include('Form.BaseForm.Inputs.select')
        </select>
      </label>
    </div>

    <div class="row">
      Наименование<span id="Name"></span>
      <input type="text" name="Name" required class="mr-border-radius-5 col-md-12 col-sm-12"
             value="{{ $tariff?$tariff->getName():null }}">

    </div>

    <div class="row">
      Цена<span id="Cost"></span>
      <input type="number" name="Cost" required class="mr-border-radius-5 col-md-12 col-sm-12"
             value="{{ $tariff?$tariff->getCost():null }}">
    </div>

    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>

@include('Form.BaseForm.footer')