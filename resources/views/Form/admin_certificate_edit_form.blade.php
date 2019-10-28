@include('Form.BaseForm.header')
<div class="container-fluid">
	<form action="/admin/certificate/edit/{{ $id }}/submit" method="post" id="mr-form">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<div>
			<div id="Kind"></div>
			<div id="CountryID"></div>
			<div id="Status"></div>
			<div id="Number"></div>
		</div>
		<label class="d-inline-flex">Тип
			<select required class="mr-border-radius-5" name="Kind">
				<option value=0>[не выбрано]</option>
				@foreach($kind as $key => $kind_item)
				@if($certificate->getKind() == $key)
				<option selected value="{{ $key }}">{{ $kind_item }}</option>
				@else
				<option value="{{ $key }}">{{ $kind_item }}</option>
				@endif
				@endforeach
			</select>
		</label>

		<label class="d-inline-flex">Статус
			<select required class="mr-border-radius-5" name="Status">
				<option value=0>[не выбрано]</option>
				@foreach($statuses as $key_status => $status)
				@if($certificate->getStatus() == $key_status)
				<option selected value="{{ $key_status }}">{{ $status }}</option>
				@else
				<option value="{{ $key_status }}">{{ $status }}</option>
				@endif
				@endforeach
			</select>
		</label>


		<div>
			<label>Страна
				<select required class="mr-border-radius-5 col-sm-12" name="CountryID">
					<option value=0>[не выбрано]</option>
					@foreach($countries as $country)
					@if($certificate->getCountry() && $certificate->getCountry()->id() == $country->id())
					<option selected value="{{ $country->id() }}">{{ $country->getNameRus() }}</option>
					@else
					<option value="{{ $country->id() }}">{{ $country->getNameRus() }}</option>
					@endif
					@endforeach
				</select>
			</label>
		</div>


		<div>
			<label>Номер
				<input type="text" name="Number" required class="mr-border-radius-5 col-sm-12"
							 value="{{ $certificate->getNumber() }}">
			</label>
		</div>
		<div>
			<label>Дата C
				<input type="date" name="DateFrom" required class="mr-border-radius-5 col-sm-12"
							 value="{{ $certificate->getDateFrom() ? $certificate->getDateFrom()->format('Y-m-d'):null }}">
			</label>
			<label>Дата По
				<input type="date" name="DateTo" required class="mr-border-radius-5 col-sm-12"
							 value="{{ $certificate->getDateTo() ? $certificate->getDateTo()->format('Y-m-d'):null }}">
			</label>
		</div>

		<div>
			<label>Примечание (для себя)<span id="Description"></span>
				<textarea name="Description"
									class="mr-border-radius-5 col-sm-12">{{ $certificate->getDescription() }}</textarea>
			</label>
		</div>
		<div>
			<label>Ссылка на оригинал<span id="LinkOut"></span>
				<input type="text" name="LinkOut" class="mr-border-radius-5 col-sm-12" value="{{ $certificate->getLinkOut() }}">
			</label>
		</div>

		<div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
			<button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
			<button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
		</div>
	</form>
</div>

@include('Form.BaseForm.footer')