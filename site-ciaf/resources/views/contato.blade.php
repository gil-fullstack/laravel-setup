@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Fale conosco</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4" id="contato">
      <div class="card p-4">
        <div class="row">
          <div class="col-12 col-md-6 p-5">
            <h3 class="mb-5">Mensagem</h3>
            <form action="{{url('salvarcontato')}}" method="POST">
              @csrf
              @if (session('success'))
                  <div class="alert alert-success mt-3">
                      {{ session('success') }}
                  </div>
              @endif
              <div class="row">

                <div class="col m-2">
                  <input type="text" class="form-control" placeholder="Nome" name="nome" required value="{{ old('nome') }}">
                </div>
                <div class="col m-2">
                  <input type="text" class="form-control phone" placeholder="Telefone" name="telefone" required value="{{ old('telefone') }}">
                </div>
              </div>
              <div class="row">
                <div class="col m-2">
                  <input type="email" class="form-control" placeholder="Email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="col m-2">
                  <input type="text" class="form-control" placeholder="Assunto" name="assunto" required value="{{ old('assunto') }}">
                </div>
              </div>
              <div class="row">
                <div class="col m-2">
                  <select class="form-control" name="onde" required>
                    <option hidden value="">Onde nos conheceu</option>
                    <option value="7">Instagram</option>
                    <option value="6">Facebook</option>
                    <option value="5">Info Exame</option>
                    <option value="1">Pesquisa Google</option>
                    <option value="2">Indicação</option>
                    <option value="4">Superdownloads</option>
                    <option value="3">Baixaki</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col m-2">
                  <textarea rows="4" class="form-control" placeholder="Mensagem" name="mensagem">{{ old('mensagem') }}</textarea>
                </div>
              </div>

              <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    {!! app('captcha')->display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="row">
                <div class="col m-2">
                  <button type="submit" class="btn btn-custom" name="button">Enviar</button>
                </div>              
              </div>
              


            </form>

            <h3 class="mt-5">Informações</h3>
            @foreach ($telefones as $key => $item)
              <div class="mb-2">
                <span class="text-muted titulo">{{$item->titulo}}:</span>
                <a href="{{$item->link}}" class="descricao" target="_blank"><strong>{{$item->descricao}}</strong></a>
              </div>
            @endforeach
            <iframe src="https://servidorseguro.mysuite.com.br/empresas/tvs/verificaseguro3.php" width="120" height="38" style="border:none"></iframe>

          </div>
          <div class="col-12 col-md-6 p-5" style="border-left:1px solid rgba(0,0,0,.1);">
            <h2 class="mb-4">VISITE-NOS</h2>
            <h3>Endereço</h3>
            <p class="mb-4 text-muted">{{$endereco->descricao}}</p>
            <iframe src="{{$endereco->link}}" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

            <h3 class="mt-5">Horário de Atendimento</h3>
            <p class="text-muted">{{$horario_atendimento->descricao}}</p>
          </div>
        </div>
      </div>
    </div>

@endsection
