<div>
  <label>{{ $item['#title'] }}
    <input type="text" name="{{ $name }}" value="{{ $item['#value'] }}"
           class="@foreach($item['#class'] as $class){{ $class }}@endforeach">
  </label>
</div>