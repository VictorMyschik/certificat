<label>{{ $item['#title'] }}
  <input type="number" name="{{ $name }}" value="{{ $item['#value'] }}" class="@foreach($item['#class'] as $class){{ $class }}@endforeach">
</label>