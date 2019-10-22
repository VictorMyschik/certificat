@include('Form.BaseForm.header')
<script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
<div class="container-fluid">
	<form action="/admin/message/{{ $id }}/submit" method="post" id="mr-form">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<label class="col-md-12 col-sm-12"><span class="mr-bold">Заголовок</span><span id="Title" class="mr-middle"></span>
			<input type="text" name="Title" class="mr-border-radius-10 col-md-12 col-sm-12"
			       value="{{ $message->getTitle()?:null }}">
		</label>

		<div class="margin-t-10 margin-b-10">
			<label class="col-md-12 col-sm-12"><span class="mr-bold">От кого: </span>
				<select class="mr-border-radius-10" name="FromUserID">
					<option value=0>[не выбрано]</option>

					<option value="-1">[все]</option>
					@if($message->getFromUser())
						<option selected="selected"
						        value="{{ $message->getFromUser()->id() }}">
							выбрано: {{ $message->getFromUser()->getName().' ('.$message->getFromUser()->getEmail().')' }}</option>
					@endif
					@foreach($users as $user)
						<option value="{{ $user->id() }}">{{ $user->getName().' ('.$user->getEmail().')' }}</option>
					@endforeach
				</select>
			</label>

			<div class="col-md-12 col-sm-12"><span class="mr-bold">Для кого: </span>
				@if($message->getToUser())
					<label>все <input type="checkbox" name="all_to"></label>
				@else
					<label>все <input type="checkbox" checked="checked" name="all_to"></label>
				@endif

				<label>
					<select class="mr-border-radius-10" name="ToUserID">
						<option value=0>[не выбрано]</option>
						<option value="-1">[все]</option>
						@if($message->getToUser())
							<option selected="selected"
							        value="{{ $message->getToUser()->id() }}">
								выбрано: {{ $message->getToUser()->getName().' ('.$message->getToUser()->getEmail().')' }}</option>
						@endif
						@foreach($users as $user)
							<option value="{{ $user->id() }}">{{ $user->getName().' ('.$user->getEmail().')' }}</option>
						@endforeach
					</select>
				</label>
			</div>
		</div>

		<div>
			<div class="col-md-12">
				<textarea name="text" class="textarea" id="editor1" title="Contents">{{ $message->getText() }}</textarea>
			</div>
			<script>
        CKEDITOR.replace('editor1', {
          filebrowserBrowseUrl: '/elfinder/ckeditor',
          height: 100,
        });
			</script>
			<script>
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
          modal_this = this
          $(document).on('focusin.modal', function (e) {
            if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
              && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
              && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
              modal_this.$element.focus()
            }
          })
        };
			</script>
		</div>
		<div class="margin-t-15 d-md-flex d-sm-flex justify-content-center">
			<button type="submit" id="mr-btn" class="mr-sumbit-success m-2">{{ $btn_success }}</button>
			<button type="button" class="mr-sumbit-cancel m-2" data-dismiss="modal">{{ $btn_cancel }}</button>
		</div>
	</form>
</div>


@include('Form.BaseForm.footer')