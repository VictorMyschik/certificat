<label>{{ $item['#title'] }}
  <input type="number" name="{{ $name }}" value="{{ $item['#value'] }}"
         @if(isset($item['#class']))class="@foreach($item['#class'] as $class){{ $class }}@endforeach"@endif>
</label>