<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Policy редактирование</title>

<link rel="stylesheet" href="/public/css/flaticon.css">
<link rel="stylesheet" href="/public/css/icomoon.css">
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
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
<link rel="stylesheet" href="/public/css/mr-style.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
@extends('Admin.layouts.app')

@section('content')
<div id="right-panel" class="right-panel">
	<div class="breadcrumbs">
		<div class="col-sm-4">
			<div class="page-header float-left">
				<div class="page-title">
					<h1>Редактирование</h1>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="page-header float-right">
				<div class="page-title">
					<ol class="breadcrumb text-right">
						<li><a href="/admin">Главная</a></li>
						<li><a href="/admin/policy">Все языки</a></li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="padding-horizontal">
		{{ Form::open(['name'=>'edit_article','method' => 'post', 'enctype'=>'multipart/form-data', 'files' => true]) }}
		{{ Form::token() }}
		<div class="margin-b-20 margin-t-15">
			<div class="mr-bold">Язык</div>
			<select class="mr-border-radius-5 col-md-4" name="LanguageID">
				<option value="0">[не выбрано]</option>
				@foreach($languages as $language)
				@if($policy->getLanguage()->id() == $language->id())
				<option selected="selected" value="{{ $language->id() }}">{{ $language->getName() }}
					({{ $language->getDescription() }})
				</option>
				@else
				<option value="{{ $language->id() }}">{{ $language->getName() }} ({{ $language->getDescription() }})
				</option>
				@endif
				@endforeach
			</select>
		</div>
		<div class="col-md-9 col-sm-12 padding-0">
			<b>Текст</b>
			<textarea name="Text" class="textarea" id="editor1" title="Contents">{{ $policy->getText() }}</textarea>
			<button type="submit" class="btn btn-sm btn-primary mr-border-radius-5 margin-t-20 margin-b-20">Сохранить</button>
		</div>
		<script>
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: '/elfinder/ckeditor'
        });
		</script>
		{!! Form::close() !!}
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
