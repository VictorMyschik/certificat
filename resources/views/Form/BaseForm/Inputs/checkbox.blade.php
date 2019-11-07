<div>
  <label>
    {{ $item['#title'] }}
    <input type="checkbox" name="{{ $name }}" value="{{ $item['#value'] }}" {{ $item['#checked']?'checked':null }}
    @if(isset($item['#attributes'])) @foreach($item['#attributes'] as $attribute){{ $attribute }} @endforeach @endif
    @if(isset($item['#class']))class='@foreach($item['#class'] as $class){{ $class }}@endforeach' @endif>
  </label>
</div>