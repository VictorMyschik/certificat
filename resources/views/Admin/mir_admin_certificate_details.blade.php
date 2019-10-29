<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Сведения о сертификате</title>
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
					<h1>Сведения о сертификате:
						{!! \App\Http\Controllers\Forms\MrForm::loadForm('admin_certificate_details_edit_form', 'MrCertificateDetailsEditForm',
						['certificate_id'=>$certificate->id(),'id' => '0'], '',['btn btn-primary btn-sm fa fa-plus']) !!}
					</>
				</div>
			</div>
		</div>

	</div>

	<div class="animated fadeIn">
		<div class="card-body padding-horizontal">
			{!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
			<h4 class="margin-t-10">Сертификат: {{ $certificate->GetFullName() }}</h4>
			<hr>
			<table id="bootstrap-data-table-export" class="table table-striped table-bordered mr-middle">
				<thead>
				<tr>
					<td>ID</td>
					<td>Поле</td>
					<td>Значение</td>
					<td>Актуален</td>
					<td>#</td>
				</tr>
				<thead>
				<tbody>
				@foreach($list as $value)
				<tr>
					<td>{{ $value->id() }}</td>
					<td>{{ $value->getField() }}</td>
					<td>{{ $value->getValue() }}</td>
					<td>{{ $value->getWriteDate()->format('d.m.Y H:i:s') }}</td>
					<td>
						{!! \App\Http\Controllers\Forms\MrForm::loadForm('admin_certificate_details_edit_form', 'MrCertificateDetailsEditForm',
						['certificate_id'=>$certificate->id(),'id' => $value->id()], '',['btn btn-primary btn-sm fa fa-edit']) !!}
						<a href="/admin/certificate/{{ $certificate->id() }}/details/delete/{{ $value->id() }}" onclick="return confirm('Вы уверены?');">
							<button type="button" class="btn btn-danger btn-sm mr-border-radius-5"><i class="fa fa-trash-o"></i>
							</button>
						</a></td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>

	</div><!-- .animated -->


</div><!-- /#right-panel -->
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

