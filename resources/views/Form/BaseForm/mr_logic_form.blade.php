@foreach($form as $key => $items)

  @if(isset($items['#type']))

    @if($items['#type'] == 'select')
      @include('Form.BaseForm.Inputs.select', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'textfield')
      @include('Form.BaseForm.Inputs.textfield', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'textarea')
      @include('Form.BaseForm.Inputs.textarea', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'number')
      @include('Form.BaseForm.Inputs.number', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'checkbox')
      @include('Form.BaseForm.Inputs.checkbox', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'date')
      @include('Form.BaseForm.Inputs.date', ['name' => $key, 'item' => $items])
    @endif

    @if($items['#type'] == 'datetime')
      @include('Form.BaseForm.Inputs.datetime', ['name' => $key, 'item' => $items])
    @endif

  @else
    @if(substr($key, 0, 1) !== '#')
      <div>
        {!! $items !!}
      </div>
    @endif
  @endif

@endforeach