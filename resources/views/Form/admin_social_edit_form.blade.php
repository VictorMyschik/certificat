@include('Form.BaseForm.header')
<div class="container-fluid">
  <form action="/admin/social/edit/{{ $id }}/submit" method="post" id="mr-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="">
      <label>Наименование<span id="Name"></span>
        <input name="Name" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getName() }}">
      </label>
    </div>

    <div class="">
      <label>Примечание<span id="Description"></span>
        <input name="Description" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getDescription() }}">
      </label>
    </div>

    <div class="">
      <label>Шаблон <span class="mr-small">( {{ htmlspecialchars('a href=tel:telegram/mr-id mr-name /a') }})</span><span id="Templates"></span>
        <input name="Templates" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getTemplates() }}">
      </label>
    </div>

    <div class="">
      <label>Постфикс <span class="mr-small"></span><span id="Postfix"></span>
        <input name="Postfix" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getPostfix() }}">
      </label>
    </div>

    <div class="">
      <label>Ссылка на главную<span id="Link"></span>
        <input name="Link" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getLink() }}">
      </label>
    </div>

    <div class="">
      <label>Партнёрская ссылка<span id="Link"></span>
        <input name="LinkPartner" class="mr-border-radius-10 col-sm-12" type="text" value="{{ $social->getLinkPartner() }}">
      </label>
    </div>

    <div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
      <button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
    </div>
  </form>
</div>
@include('Form.BaseForm.footer')