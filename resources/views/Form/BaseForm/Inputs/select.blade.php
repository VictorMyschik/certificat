<div id="{{ $name }}"></div>
{{ $item['#title'] }}
<label>
  <select class="mr-border-radius-5" name="{{ $name }}">
    @foreach($item['#value'] as $key => $value)
      @if(isset($item['#default_value']) && ($item['#default_value'] == $key))
        <option selected="selected" value="{{ $key }}">{{ $value }}</option>
      @else
        <option value="{{ $key }}">{{ $value }}</option>
      @endif
    @endforeach
  </select>
</label>