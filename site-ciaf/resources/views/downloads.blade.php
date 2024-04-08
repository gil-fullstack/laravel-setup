@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Downloads</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="list-group" style="padding-top:80px; padding-bottom:80px">

        @foreach ($produtos as $key => $item)
          <div class="list-group-item py-4">
            <div class="row align-items-center justify-content-center">
              <div class="col-12 col-md-4 text-center">
                <img src="{{asset('storage/'.$item->imagem_destaque)}}" class="img-fluid" alt="{{$item->titulo}}">
                <div class="d-flex justify-content-center align-items-center">
                  <a href="{{url('solucoes_detalhes/'.$item->id)}}" class="btn btn-primary btn-sm m-3" style="background-color:#0B2C52; border-color:#0B2C52"><i class="fas fa-search mr-2"></i>Detalhes</a>
                  <a href="{{url('download_produto/'.$item->id)}}" class="btn btn-primary btn-sm m-3" style="background-color:#0B2C52; border-color:#0B2C52"><i class="fas fa-download mr-2"></i>Download</a>
                </div>
              </div>
              <div class="col-12 col-md-8">
                <div class="d-flex w-100 justify-content-between mb-3">
                  <h4 class="mb-1 font-weight-bolder">{{$item->titulo}}</h4>
                </div>
                <p><strong class="text-danger">Usuário: CIAF / Senha: CIAF</strong> || {{$item->descricao}}</p>
              </div>
            </div>
          </div>
        @endforeach




      </div>
    </div>

@endsection
