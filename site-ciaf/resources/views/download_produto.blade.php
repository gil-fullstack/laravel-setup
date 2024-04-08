@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Download</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">
      <form method="POST" action="{{url('checkout_download')}}">
        @csrf
        <div class="row">

          <div class="col-md-4 px-2">
            <div class="card p-3">
              <img src="{{asset('storage/'.$produto->imagem_destaque)}}" class="img-fluid">
              <div class="card-body">
                <h3 class="card-title"><strong>{{$produto->titulo}}</strong></h3>
                <div class="text-left mt-3">
                  {{-- <a role="button" data-toggle="collapse" href="#solucao_1" aria-expanded="false" aria-controls="solucao_1" class="text-center my-3 solucao-toggle"><i class="fas fa-plus mr-2"></i><span>Mais detalhes</span></a> --}}

                  <a href="{{url('solucoes/'.$produto->categoria->id)}}" class="text-center my-3"><i class="fas fa-plus mr-2"></i><span>Ver Funcionalidades</span></a>
                  <div class="collapse text-left mt-3" id="solucao_1">
                    @php
                      $funcionalidades_id = 0
                    @endphp
                    @foreach ($produto->roles()->orderBy('funcionalidades_id')->get() as $funcionalidade)
                      @if($funcionalidades_id != $funcionalidade->funcionalidades_id)
                        <a href="{{url('funcionalidades/'.$produto->id)}}" target="_blank">{{$funcionalidade->funcionalidade->descricao}}</a><br>
                      @endif
                      @php
                        $funcionalidades_id = $funcionalidade->funcionalidades_id;
                      @endphp
                    @endforeach

                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="col-md-8 px-2">
            <div class="card p-3">
                @if (session('link'))
                  <div class="alert alert-success mt-3">
                    O seu download começará em instantes, ou então, <a href="{{url('storage/arquivos/'.session('link')->link_download) }}" download="{{session('link')->titulo.'.exe'}}" id="download_file">clique aqui</a>.
                  </div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger mt-3">
                    {{session('error')}}
                  </div>
                @endif
                <div class="mb-3">
                  <h5 class="mb-0"><strong>Preencha os campos com as suas informações</strong></h5>
                  <small class="text-muted">(*) Campos obrigatórios</small>
                </div>
                <input type="hidden" name="produto_id" value="{{$produto->id}}">

                <div class="form-group">
                  <label>E-mail*</label>
                  <input class="form-control" type="email" name="email" required value={{old('email')}}>
                </div>
                <div class="form-group">
                  <label>Telefone*</label>
                  <input class="form-control phone" name="telefone" required value={{old('telefone')}}>
                </div>
                <div class="form-group">
                  <label>Nome (Opcional)</label>
                  <input class="form-control" name="nome" min-length="4" value={{old('nome')}}>
                </div>
                <div class="form-group">
                  <label>Empresa (Opcional)</label>
                  <input class="form-control" name="empresa" min-length="4" value={{old('empresa')}}>
                </div>
                <div class="form-group">
                  <label>Onde nos conheceu?*</label>
                  <select class="form-control" name="onde" required>
                    <option hidden value="">Selecione uma opção</option>
                    <option value="7">Instagram</option>
                    <option value="6">Facebook</option>
                    <option value="5">Info Exame</option>
                    <option value="1">Pesquisa Google</option>
                    <option value="2">Indicação</option>
                    <option value="4">Superdownloads</option>
                    <option value="3">Baixaki</option>
                  </select>
                </div>

                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                  {!! app('captcha')->display() !!}
                  @if ($errors->has('g-recaptcha-response'))
                      <span class="help-block text-danger">
                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                      </span>
                  @endif
              </div>

                <button type="submit" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Fazer Download</button>



            </div>

          </div>
        </div>
      </form>
    </div>

    @if (session('link'))
      <script>
      $(document).ready(function(){
        console.log($('#download_file'));
        $('#download_file')[0].click();
      })

      </script>
    @endif

@endsection
