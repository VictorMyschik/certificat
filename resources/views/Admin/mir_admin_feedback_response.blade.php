<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Обратная связь</title>
<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="/public/css/flaticon.css">
<link rel="stylesheet" href="/public/css/icomoon.css">
<link rel="stylesheet" href="/public/css/mr-style.css">

<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/public/vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
@extends('Admin.layouts.app')

@section('content')
	<div id="right-panel" class="right-panel">

		<div class="breadcrumbs">
			<div class="col-sm-4">
				<div class="page-header float-left">
					<div class="page-title">
						<h1>Обратная связь</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li><a href="/admin">Главная</a></li>
							<li><a href="/admin/feedback">Список сообщений</a></li>
							<li class="active">Обратная связь</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class=" col-md-12">
			<div class="animated fadeIn">
				<h5>От:</h5>
				<div class="mr_bold col-md-4 col-sm-12">{{ $message->getName() }}</div>
				<div class="mr_bold col-md-4 col-sm-12">{{ $message->getEmail() }}</div>
				<div class="mr_bold col-md-4 col-sm-12">{{  date('d M Y H:i', strtotime($message->getDate())) }}</div>
				<h5>Текст:</h5>
				<div class="col-md-12">{{ $message->getText() }}</div>
				<h5>Ответ:</h5>
				<form action="/admin/feedback/edit/send/{{ $message->id() }}" method="post">
					{{ Form::token() }}
					<textarea name="text" class="textarea" id="editor1"
					          title="Contents">{{ $message->getSendMessage() }}</textarea>
					<script>
            CKEDITOR.replace('editor1', {
              filebrowserBrowseUrl: '/elfinder/ckeditor'
            });
					</script>

					<br>
					<button type="submit" class="btn btn-primary mr-border-radius-10">Отправить</button>
				</form>
			</div>
		</div>


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
