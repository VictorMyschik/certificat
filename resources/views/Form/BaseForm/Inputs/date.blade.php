<div class="">
  <label>
    {{ $item['#title'] }}
    <input type="date" name="{{ $name }}" value="{{ $item['#value'] }}"
           @if(isset($item['#attributes'])) @foreach($item['#attributes'] as $attribute){{ $attribute }} @endforeach @endif
           class='mr-border-radius-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif'>
  </label>
</div>