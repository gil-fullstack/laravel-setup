@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Manuais</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <ul class="list-group">
        @foreach ($manuais as $key => $item)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{$item->titulo}}
            <a href="{{url('/storage/'.$item->arquivo)}}" target="_blank"><i class="fas fa-download text-info"></i></a>
          </li>
        @endforeach

      </ul>
    </div>

@endsection
