@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Suporte</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="row row-cols-2 row-cols-md-3">
        @foreach ($suporte as $key => $item)
          <div class="col mb-4">
            <div class="card h-100 text-center">
              <div class="card-body">
                <a href="{{$item->link}}" target="{{filter_var($item->link, FILTER_VALIDATE_URL) ? '_blank' : ''}}" class="text-dark">
                  <img src="{{asset('storage/'.$item->imagem)}}" class="img-fluid text-center" alt="{{$item->titulo}}" width="80">
                  <h5 class="card-title">{{$item->titulo}}</h5>
                  <p class="card-text">{{$item->descricao}}</p>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

@endsection
