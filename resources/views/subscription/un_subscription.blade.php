@extends('layouts.app')

@section('content')

  <section class="ftco-section-parallax">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <br>
            <h4 class="text-white">
              {{ $message }}
            </h4>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection