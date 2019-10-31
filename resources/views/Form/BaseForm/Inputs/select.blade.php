{{ $item['#title'] }}
<label><span class="@if(isset($item['#class']))@foreach($item['#class'] as $class){{ $class }}@endforeach @endif"></span>
  <select class="mr-border-radius-5" name="{{ $name }}">
    <option value="0">[не выбрано]</option>
    @foreach($item['#value'] as $key => $item)
      @if(isset($item['#default_value']) && $item['#default_value'] == $key)
        <option selected="selected" value="{{ $key }}">{{ $item }}</option>
      @else
        <option value="{{ $key }}">{{ $item }}</option>
      @endif
    @endforeach
  </select>
</label>