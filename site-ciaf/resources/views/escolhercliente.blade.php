@extends('layouts/master')
@section('content')
    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Área do Cliente</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>
    <div class="container py-4">
      <div>
        <h4>Escolha o cliente</h4><br>
        @foreach ($cliente as $key => $item)
          <a href="{{url('escolher_cliente/'.$item->codigo)}}" class="btn btn-danger my-2">{{$item->codigo.' - '.$item->nome}}</a>
          <br>
        @endforeach
      </div>
    </div>
@endsection
