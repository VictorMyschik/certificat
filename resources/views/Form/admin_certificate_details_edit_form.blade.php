@include('Form.BaseForm.header')
<div class="container-fluid">
	<form action="/admin/certificate/{{ $certificate->id() }}/details/edit/{{ $id }}/submit" method="post" id="mr-form">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<div class="margin-b-20">
			<h4>Сертификат: {{ $certificate->GetFullName() }}</h4>
		</div>

		<div class="row">
			Поле<span id="Field"></span>
			<input type="text" name="Field" required class="mr-border-radius-5 col-md-12 col-sm-12"
						 value="{{ $certificate_details?$certificate_details->getField():null }}">

		</div>

		<div class="row">
			Значение<span id="Value"></span>
			<textarea name="Value" required
								class="mr-border-radius-5 col-md-12 col-sm-12">{{ $certificate_details?$certificate_details->getValue():null }}</textarea>

		</div>

		<div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
			<button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
			<button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
		</div>
	</form>
</div>

@include('Form.BaseForm.footer')