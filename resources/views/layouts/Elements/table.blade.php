<div>
  <mr-table
    @if(isset($route_name))
    :mr_route="'{{$route_name}}'"
    @endif
    @if(isset($table))
    :mr_object='@json($table)'
    @endif
  ></mr-table>
</div>