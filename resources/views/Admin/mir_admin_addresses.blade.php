@extends('layouts.app')

@section('content')
  @include('Admin.layouts.nav_bar')
  <div class="container">
    <a href="{{route('admin_addresses_page')}}">
    @include('Admin.layouts.page_title')
    </a>
    (<span title="{{ $country->getContinentName() }}">{{$country->getContinentShortName()}}</span>)
    {{ $country->getName() }} |
    <span title="столица">{{ $country->getCapital() }}</span>
    <hr>
    <div class="margin-b-15 margin-t-10">
      {!! MrBtn::loadForm('admin_address_form_edit', ['country_id'=>$country->id(), 'id' => '0'], 'Новый', ['btn-success', 'btn-xs'], 'xs') !!}
      <a href="{{ route('reference_country') }}" onclick="return confirm('Вы уверены?');"></a>
    </div>
    {!! MrMessage::GetMessage() !!}
    {!! $table !!}
  </div>
@endsection
