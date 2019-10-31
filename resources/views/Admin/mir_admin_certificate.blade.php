<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Сертификаты</title>
<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="/public/css/mr-style.css">
@extends('Admin.layouts.app')

@section('content')
<div id="right-panel" class="right-panel">


	<div class="breadcrumbs">
		<div class="col-sm-4">
			<div class="page-header float-left">
				<div class="page-title">
					<h1>Сертификаты</h1>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="page-header float-right">
				<div class="page-title">
					<ol class="breadcrumb text-right">
						<li><a href="/admin">Главная</a></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content mt-3">

		<div class="card-body">
			<div class="card-body padding-horizontal">
				{!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
				<h4>Добавить сертификат
					{!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_form_edit', 'Admin\\MrCertificateEditForm', ['id'
					=>'0'],	'Новый',['btn btn-info btn-sm']) !!}
				</h4>
				<table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
					<thead>
					<tr>
						<td>ID</td>
						<td>Тип</td>
						<td>Номер</td>
						<td>Дата с</td>
						<td>Дата по</td>
						<td>Страна</td>
						<td>Статус</td>
						<td>ссылка</td>
						<td>Примечание</td>
						<td>Актуален</td>
						<td>#</td>
					</tr>
					</thead>
					<tbody>
					@foreach($list as $certificate)
					<tr>
						<td>{{ $certificate->id() }}</td>
						<td>{{ $certificate->getKindName() }}</td>
						<td>{{ $certificate->getNumber() }}</td>
						<td>{{ $certificate->getDateFrom()->format('d.m.Y') }}</td>
						<td>{{ $certificate->getDateTo()->format('d.m.Y') }}</td>
						<td>{{ $certificate->getCountry()->getNameRus() }}</td>
						<td>{{ $certificate->getStatusName() }}</td>
						<td><a href="{{ $certificate->getLinkOut() }}" target="_blank">ссылка</a></td>
						<td>{{ $certificate->getDescription() }}</td>
						<td>{{ $certificate->getWriteDate()->format('d.m.Y H:i:s') }}</td>
						<td class="padding-horizontal small">
							{!! \App\Http\Controllers\Forms\FormBase\MrForm::loadForm('admin_certificate_edit_form', 'Admin\\MrCertificateEditForm',
							['id' =>
							$certificate->id()], '',['btn btn-info btn-sm fa fa-edit']) !!}

							<a href="/admin/certificate/details/{{ $certificate->id() }}">
								<button type="button" class="btn btn-primary btn-sm fa da-edit mr-border-radius-5"><span
										class="fo fa-eye"></span></button>
							</a>
							<a href="/admin/certificate/delete/{{ $certificate->id() }}" onclick="return confirm('Вы уверены?');">
								<button type="button" class="btn btn-danger btn-sm fa da-edit mr-border-radius-5"><span
										class="fo fa-trash-o"></span></button>
							</a>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<hr>

	<script src="/public/vendors/jquery/dist/jquery.min.js"></script>
	<script src="/public/vendors/popper.js/dist/umd/popper.min.js"></script>
	<script src="/public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/public/js/js/main.js"></script>

	<script src="/public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/public/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/public/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="/public/vendors/jszip/dist/jszip.min.js"></script>
	<script src="/public/vendors/pdfmake/build/pdfmake.min.js"></script>
	<script src="/public/vendors/pdfmake/build/vfs_fonts.js"></script>
	<script src="/public/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/public/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/public/vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="/public/js/js/init-scripts/data-table/datatables-init.js"></script>
	@endsection

