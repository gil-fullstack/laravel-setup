@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">{{$produto->titulo}}</h1>Escolha um plano
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4" id="produto_detalhe">
      <div class="row">
        <div class="col-md-6">
          <img src="{{asset('storage/'.$produto->imagem)}}" class="img-fluid w-100" alt="">
        </div>
        <div class="col-md-6">
          <!-- <h2 class="title">{{$produto->titulo}}</h2> -->
          <h3 style="font-weight:bold; font-size:12pt;" class="text-muted">{{$produto->descricao}}</h3>

          @foreach ($precos as $key => $item)
            @php
              if($item->categoria_id == 1){
                $preco = number_format($item->preco/12,2,'.','');
              }
              else{
                $preco = number_format($item->preco,2,'.','');
              }
            @endphp
            <div class="price" data-id={{$key+1}} style="display:none">
              <div>
                <span>R$</span>
                <span>{{floor($preco)}}</span>
                <span>,{{explode('.', $preco)[1]}} {{$item->categoria_id == 1 ? '/mês' : ''}}</span>
              </div>
              <small>{{$item->obs}}</small>
            </div>
          @endforeach

          <form action="{{url('checkout/'.$produto->id)}}" method="GET">
            <div class="form-group mb-5">
              <label>Escolha um plano</label>
              <select class="custom-select custom-select-sm" id="tipo_plano" name="plano">
                <option hidden value="0">Selecione um plano</option>
                @foreach ($precos as $key => $item)
                  <option value={{$item->categoria_id}}>{{$item->categoria->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex justify-content-center align-items-center my-3">
              <button type="submit" class="btn btn-custom-2 mx-3">Comprar</button>
              @if($produto->link_download)
                <a href="{{url('download_produto/'.$produto->id)}}" class="btn btn-custom-2 mx-3">Testar</a>
              @endif
            </div>
          </form>

          <h4 style="font-size:12pt; font-weight:bold" class="text-muted">Detalhes</h4>
          {!!$produto->texto!!}
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade mt-3" id="modal_comprar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:999999999">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Formulário de download - Seu IP: 177.92.206.217</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{url('checkout_download')}}">
            @csrf
          <div class="modal-body">

              <div class="mb-3">
                <h5 class="mb-0"><strong>Preencha os campos com as suas informações</strong></h5>
                <small class="text-muted">(*) Campos obrigatórios</small>
              </div>
              <input type="hidden" name="produto_id" value="{{$produto->id}}">

              <div class="form-group">
                <label>E-mail*</label>
                <input class="form-control" type="email" name="email" required>
              </div>
              <div class="form-group">
                <label>Telefone*</label>
                <input class="form-control phone" name="telefone" required>
              </div>
              <div class="form-group">
                <label>Nome (Opcional)</label>
                <input class="form-control" name="nome" min-length="4">
              </div>
              <div class="form-group">
                <label>Empresa (Opcional)</label>
                <input class="form-control" name="empresa" min-length="4">
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

          </div>
          <div class="modal-footer">
            <button type="submit" name="button" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Download</button>
            <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="carousel slide cta">
      <div class="carousel-inner">
        <div class="carousel-item active d-flex justify-content-center align-items-center flex-column" style="background-image:url({{asset('storage/'.$cta_produto->imagem)}}); background-size:cover; background-position:center; height:300px">
          <div class="overlay"></div>
          <div class="text-center position-relative container">
            <h3 class="mb-3">{{$cta_produto->titulo}}</h3>
            <hr style="border: 1px solid #CC1707">
            <button type="button" name="button" class="btn btn-custom btn-cta">Ligue para mim</button>
          </div>

        </div>
      </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
          $('#tipo_plano').val(0);
        })
    </script>

@endsection
