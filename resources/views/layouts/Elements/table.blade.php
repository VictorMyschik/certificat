<div>
  <table>
    <thead>
    <tr>
      @foreach($data['header'] as $h_data)
        @foreach($h_data as $h_key => $name)
          <td>{{$name}}</td>
        @endforeach
      @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data['body'] as $b_data)
      <tr>
        @foreach($b_data as $b_key => $name)
          <td>{{$name}}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>
</div>