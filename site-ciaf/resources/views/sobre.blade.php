@extends('layouts/master')
@section('content')
    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Sobre</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="card-deck">
        @foreach ($valores as $key => $item)
          <div class="card">
            <div class="card-body">
              <h5 class="card-title title">{{$item->titulo}}</h5>
              <p class="card-text">{{$item->descricao}}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="container py-4">
      <div class="row">
        <div class="col-12 col-md-6">
          <img src="{{asset('storage/'.$sobre->imagem)}}" class="img-fluid" alt="{{$sobre->titulo}}">
        </div>
        <div class="col-12 col-md-6">
          <div align="justify">
            <font color="#666666"><strong>{{$sobre->titulo}}</strong></font>
            <br><br>
            {!!$sobre->texto!!}
          </div>
        </div>
      </div>
    </div>

@endsection
