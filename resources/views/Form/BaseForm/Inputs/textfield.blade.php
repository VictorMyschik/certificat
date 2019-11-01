<div>
  <label>{{ $item['#title'] }}
    <input type="text" name="{{ $name }}" value="{{ $item['#value'] }}"
           class="mr-border-radius-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif">
  </label>
</div>