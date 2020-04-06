<a title="{{ $title }}" href="{{ route($url,$arguments) }}"
   @foreach($attributes as $key=>$item)
       {{$key}}="{{$item}}"
   @endforeach
   class="{{ $class }}">{{ $text }}</a>