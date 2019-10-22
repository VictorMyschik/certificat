@extends('layouts.app')

@section('content')

  <section class="ftco-section-parallax">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Не пропустите обновления</h2>
            <p>Подписка одной кнопкой позволит не пропустить горящие туры и интересные статьи о путешествиях</p>
            <div class="row d-flex justify-content-center mt-5">
              <div class="col-md-8">
                <form action="/subscription" method="POST" class="subscribe-form">
                  {{ Form::token() }}
                  <div class="form-group d-flex">
                    <input type="text" class="form-control" name="email" required placeholder="Просто введите ваш Email">
                    <input type="submit" value="GO" class="submit px-sm-2">
                  </div>
                </form>
              </div>
            </div>
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