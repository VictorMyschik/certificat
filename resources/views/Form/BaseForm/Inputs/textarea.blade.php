<div><span id="{{ $name }}"></span>
  {{ $item['#title'] }}
  <textarea type="text" name="{{ $name }}" id="editor1" {{ $item['#required']??null }}
            class="mr-border-radius-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif">
    {{ old($name, $item['#value']) }}
    </textarea>
</div>
@if(!empty($item['#ckeditor']))
  <script>
      CKEDITOR.replace('editor1', {
          filebrowserBrowseUrl: '/elfinder/ckeditor'
      });
  </script>
@endif