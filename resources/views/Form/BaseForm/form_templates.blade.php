<div class="container-fluid" style="padding: 0;">
  <form action="{{$form['#url']}}" method="post" id="mr-form" style="margin-bottom: 0; padding: 0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h4>{{ $form['#title'] }}</h4>
    <hr>
    <div id="errors"></div>
    @foreach($form as $key => $items)

      @if(isset($items['#type']))
        @include("Form.BaseForm.Inputs.{$items['#type']}", ['name' => $key, 'item' => $items])
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
      @if(!isset($form['#btn_info']))
        <button type="submit" id="mr-btn" class="btn btn-primary btn-xs">{{ $form['#btn_success'] }}</button>
        <button type="button" class="btn btn-danger btn-xs m-l-5"
                data-dismiss="modal">{{ $form['#btn_cancel'] }}</button>
      @else
        <button type="button" class="btn btn-success btn-xs m-l-5"
                data-dismiss="modal">{{ $form['#btn_info'] }}</button>
      @endif
    </div>
  </form>
</div>
<script src="/public/js/mr-popup.js"></script>