@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px; margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/images/noticias.jpg')}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0 text-center">{{$noticia->titulo}}</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
            <p class="lead text-dark">{{$noticia->created_at->locale('pt-BR')->isoFormat('D \d\e MMMM \d\e Y')}}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <p>{!!$noticia->texto!!}</p>
    </div>

@endsection
