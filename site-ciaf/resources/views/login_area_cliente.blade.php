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

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="{{url('area_cliente')}}">
                @csrf
                <div class="form-group">
                  <label>CNPJ da empresa</label>
                  <input class="form-control cnpj" placeholder="Somente números" name="cnpj" required>
                </div>
                <div class="form-group">
                  <label>Senha</label>
                  <input type="password" class="form-control" placeholder="Digite aqui" name="senha" required>
                </div>
                <button type="submit" class="btn btn-custom-2">Acessar</button>

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
