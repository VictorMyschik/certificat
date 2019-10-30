<option value="0">[не выбрано]</option>
@foreach($list as $key => $item)
  @if($default_select == $key)
    <option selected="selected" value="{{ $key }}">{{ $item }}</option>
  @else
    <option value="{{ $key }}">{{ $item }}</option>
  @endif
@endforeach