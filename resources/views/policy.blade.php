@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center"
		     data-scrollax-parent="true">
			<div class="col-md-9 ftco-animate margin-t-20">
				{!! $policy?$policy->getText():null !!}
			</div>
		</div>
	</div>
@endsection

