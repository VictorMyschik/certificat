@extends('layouts.app')

@section('content')
	@include('layouts.mr_nav')
<div class="container">
	<div class="margin-t-20 margin-b-20">
		<h3>{{ __('mr-t.Документ' )}}: {{ $certificate->getKindName().' '.$certificate->GetFullName() }}</h3>
		<u class="mr-color-green-dark">{{ __('mr-t.Сведения обновлены') }}: {{ $actual_date->format('d.m.Y h:i:s')
			}}</u>
	</div>

	<table class=margin-b-20>
		<thead>
		<thead>
		<tbody>
		<tr>
			<td class="mr-bold">{{ __('mr-t.Тип') }}</td>
			<td class="padding-l-20">{{ $certificate->getKindName() }}</td>
		</tr>
		<tr>
			<td class="mr-bold">{{ __('mr-t.Страна') }}</td>
			<td class="padding-l-20">{{ $certificate->getCountry()->getCodeWithName() }}</td>
		</tr>
		<tr>
			<td class="mr-bold">{{ __('mr-t.Номер') }}</td>
			<td class="padding-l-20">{{ $certificate->getNumber() }}</td>
		</tr>
		<tr>
			<td class="mr-bold">{{ __('mr-t.Дата с') }}</td>
			<td class="padding-l-20">{{ $certificate->getDateFrom()->format('d.m.Y') }}</td>
		</tr>
		<tr>
			<td class="mr-bold">{{ __('mr-t.Срок действия') }}</td>
			<td class="padding-l-20">{{ $certificate->getDateTo()->format('d.m.Y') }}</td>
		</tr>
		</tbody>
	</table>



	<h4>{{ __('mr-t.Дополнительные сведения') }}</h4>
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
		<thead>
		<tr class="mr-bold">
			<td>{{ __('mr-t.Параметр') }}</td>
			<td>{{ __('mr-t.Значение') }}</td>
		</tr>
		<thead>
		<tbody class="mr-middle">
		@foreach($certificate->GetDetails() as $details)
		<tr>
			<td>{{ $details->getField() }}</td>
			<td>{{ $details->getValue() }}</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection

