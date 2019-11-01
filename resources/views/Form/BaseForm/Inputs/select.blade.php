<div id="{{ $name }}"></div>
{{ $item['#title'] }}
<label>
  <select class="mr-border-radius-5"
  @if(isset($item['#attributes']))
    @foreach($item['#attributes'] as $attr_key => $attr_val)
      {{ $attr_key }}='{{ $attr_val }}'
    @endforeach
  @endif
  name="{{ $name }}">
  @foreach($item['#value'] as $key => $value)
    @if(isset($item['#default_value']) && ($item['#default_value'] == $key))
      <option selected="selected" value="{{ $key }}">{{ $value }}</option>
    @else
      <option value="{{ $key }}">{{ $value }}</option>
      @endif
      @endforeach
      </select>
</label>