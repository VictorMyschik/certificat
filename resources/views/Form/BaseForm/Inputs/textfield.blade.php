<span id="{{ $name }}"></span>
<label class="col-sm-12 mr-bold" style="padding: 0;">{{ $item['#title'] }}
<input type="text" name="{{ $name }}" value="{{ $item['#value'] }}" placeholder='{{ $item['#placeholder'] ?? null }}'
@if(isset($item['#attributes'])) @include('layouts.Elements.input_attr',['attributes'=>$item['#attributes']]) @endif
class="col-sm-12 mr-border-radius-5 p-l-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif">
</label>
