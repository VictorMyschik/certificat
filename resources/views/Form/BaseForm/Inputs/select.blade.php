{{ $Category['#title'] }} <span class="mr-middle"></span>
  <select class="mr-border-radius-5" name="LanguageID">
    <option value="0">[не выбрано]</option>
    @foreach($Category['#value'] as $key => $item)
      @if($Category['#default'] == $key)
        <option selected="selected" value="{{ $key }}">{{ $item }}</option>
      @else
        <option value="{{ $key }}">{{ $item }}</option>
      @endif
    @endforeach
  </select>