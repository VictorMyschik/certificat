<div class="container-fluid" style="padding: 0;">
  <form action="{{$form['#url']}}" method="post" id="mr-form" style="margin-bottom: 0; padding: 0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h4>{{ $form['#title'] }}</h4>
    <hr>

      @foreach($form as $key => $items)

        @if(isset($items['#type']))

          @if($items['#type'] == 'select')
            @include('Form.BaseForm.Inputs.select', ['name' => $key, 'item' => $items])
          @endif

          @if($items['#type'] == 'textfield')
            @include('Form.BaseForm.Inputs.textfield', ['name' => $key, 'item' => $items])
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

    <hr>
    <div class=" d-md-flex d-sm-flex justify-content-center">
      <button type="submit" id="mr-btn" class="btn btn-primary btn-xs">{{ $form['#btn_success'] }}</button>
      <button type="button" class="btn btn-danger btn-xs margin-l-5" data-dismiss="modal">{{ $form['#btn_cancel'] }}</button>
    </div>
  </form>
</div>
<script src="/public/js/mr-popup.js"></script>