@extends('Admin.layouts.app')
@section('content')
	<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
	<div id="right-panel" class="right-panel">
		@include('Admin.layouts.page_title')
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
					<button type="submit" class="btn btn-primary btn-sm  mr-border-radius-5">Отправить</button>
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
