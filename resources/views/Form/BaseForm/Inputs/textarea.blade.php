<div><span id="{{ $name }}"></span><span class="mr-bold">{{ $item['#title'] }}</span>
  <textarea type="text" name="{{ $name }}" id="editor1"
            {{ $item['#required']??null }}
            rows="{{$item['#rows'] ?? 1}}"
            class="mr-border-radius-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif"
            style="width: 100%">{{ old($name, $item['#value']) }}
  </textarea>
</div>