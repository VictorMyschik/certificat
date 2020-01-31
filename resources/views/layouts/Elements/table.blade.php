<table class="table table-hover table-striped table-bordered mr-middle">
  <thead>
  <tr class="mr-bold">
    @foreach($table['#header'] as $row)
      <td>{{$row}}</td>
    @endforeach
  </tr>
  </thead>
  <tbody>
  @foreach($table['#rows'] as $row)
    <tr>
      @foreach($row as $item)
        <td>{!! $item !!}</td>
      @endforeach
    </tr>
  @endforeach
  </tbody>
</table>
<div>
{!! $table['#links']??null !!}
</div>