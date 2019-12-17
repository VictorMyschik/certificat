<span id="{{ $name }}"></span>
<label class="col-sm-12 mr-bold" style="padding: 0;">{{ $item['#title'] }}
  <input type="email" name="{{ $name }}" value="{{ $item['#value'] }}"
         class="col-sm-12 mr-border-radius-5 @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif">
</label>
