<span id="{{ $name }}"></span>
<label class="col-sm-12 mr-bold" style="padding: 0;">{{ $item['#title'] }}
  <input type="text" name="{{ $name }}" value="{{ $item['#value'] }}" placeholder="{{ $item['#placeholder'] ?? null }}"
  class="col-sm-12 mr-border-radius-5 padding-horizontal @if(isset($item['#class'])) @foreach($item['#class'] as $class){{ $class }}@endforeach @endif">
</label>
