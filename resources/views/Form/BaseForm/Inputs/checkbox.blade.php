<div>
  <label class="mr-bold">
    {{ $item['#title'] }}
    <input type="checkbox" name="{{ $name }}" value="{{ $item['#value'] }}" {{ $item['#checked']??null }}
    @if(isset($item['#attributes'])) @foreach($item['#attributes'] as $attribute){{ $attribute }} @endforeach @endif
    class='@if(isset($item['#class']))@foreach($item['#class'] as $class){{ $class }}@endforeach @endif'>
  </label>
</div>