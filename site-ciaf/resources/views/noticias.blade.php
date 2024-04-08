@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Notícias</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4" id="noticias">

      <div class="row row-cols-1 row-cols-md-4">
        @if($noticias->count() == 0)
          <p>Não há nenhuma notícia recente.</p>
        @endif
        @foreach ($noticias as $key => $item)
          <div class="col mb-4">
            <div class="card h-100">
              <div class="card-header">
                <small class="text-muted">{{$item->created_at->locale('pt-BR')->isoFormat('D \d\e MMMM \d\e Y')}}</small>
              </div>
              <div class="card-body">
                <h5 class="card-title">{{$item->titulo}}</h5>
                <p class="card-text descricao">{{$item->descricao}}</p>
              </div>
              <div class="card-footer text-center">
                <a href="{{url('noticias_detalhes/'.$item->id)}}" class="btn btn-custom-2">Leia Mais</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

@endsection
