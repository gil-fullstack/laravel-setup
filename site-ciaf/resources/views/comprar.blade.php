@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Comprar</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>
    <div class="container py-4" id="produtos-compra">
    <h2 class="mt-1">Gestão Online</h2>
        <hr style="border-bottom:2px solid #0B2C52">
        <div class="row">
        <div class="col-md-4 p-3">
        <div style="border:1px solid #ddd; border-radius:5px" class="d-flex flex-column align-items-center h-100 justify-content-between p-3">
                <div>
                  <div class="text-center">
                    <img src="{{asset('storage/images/logo_ciafweb.png')}}" class="img-fluid" style="max-width:200px">
                  </div>
                  <div class="text-center">
                    <div class="my-3 text-center">
                      <h4 class="mb-1 font-weight-bolder">Ciaf Web</h4>

                    </div>
                    <p class="mb-1 text-left">Gerenciar o seu negócio, de forma fácil, simples e de qualquer lugar, é o que você sonha?</p>
                    <p class="mb-1 text-left">Com o Ciaf Web, a tecnologia e a inovação colaboram com o sucesso do empresário brasileiro.</p>
                                        
                  </div>
                </div>              
                <div class="text-center">
                  <a href="{{asset('solucoes_detalhes2/'.'14')}}" class="btn btn-custom-2 mt-3 text-center">Informações</a>                 
                </div>
          </div>
          </div>
       </div>
    </div>
    <div class="container py-1" id="produtos-compra">
      @foreach ($categorias as $key => $categoria)
        @if($produtos->where('categoria_produtos_id', $categoria->id)->count() > 0)
        <h2 class="mt-1">{{$categoria->titulo}}</h2>
        <hr style="border-bottom:2px solid #0B2C52">
        <div class="row">
          @foreach ($produtos->where('categoria_produtos_id', $categoria->id) as $index => $item)
            @if($item->precos->count() > 0)
            <div class="col-md-4 p-3">
              <div style="border:1px solid #ddd; border-radius:5px" class="d-flex flex-column align-items-center h-100 justify-content-between p-3">
                <div>
                  <div class="text-center">
                    <img src="{{asset('storage/'.$item->imagem_destaque)}}" class="img-fluid" style="max-width:200px">
                  </div>
                  <div class="text-center">
                    <div class="my-3 text-center">
                      <h4 class="mb-1 font-weight-bolder">{{$item->titulo}}</h4>

                    </div>
                    <p class="mb-1 text-left">{{$item->descricao}}</p>

                    <a href="{{url('solucoes/'.$item->categoria->id)}}" class="text-center my-3"><span><i class="fas fa-plus mr-2"></i>Ver funcionalidades</span></a>
                    <div class="collapse text-center mt-3" id="{{'solucao_'.$index}}">
                      @php
                        $funcionalidades_id = 0
                      @endphp
                      @foreach ($item->roles()->orderBy('funcionalidades_id')->get() as $funcionalidade)
                        @if($funcionalidades_id != $funcionalidade->funcionalidades_id)
                          <a href="{{url('funcionalidades/'.$item->id)}}" target="_blank">{{$funcionalidade->funcionalidade->descricao}}</a><br>
                        @endif
                        @php
                          $funcionalidades_id = $funcionalidade->funcionalidades_id;
                        @endphp
                      @endforeach

                    </div>
                  </div>
                </div>

                <div class="my-3">

                  @foreach ($item->precos->sortBy('categoria_id')->values() as $key => $preco)
                    <div class="mx-3 text-center mt-3">
                      <strong class="text-info">R$ {{$preco->categoria_id == 1 ? number_format($preco->preco/12,2,',','.').'/mês' : number_format($preco->preco,2,',','.')}}</strong>
                      <br>
                      <small class="text-muted">{{$preco->categoria->nome}}</small>
                      <br>
                      <small class="text-muted">{{$preco->obs}}</small>
                    </div>
                  @endforeach
                </div>

                <div class="text-center">
                  <a href="{{url('checkout/'.$item->id)}}" class="btn btn-custom-2 mt-3 text-center">Comprar</a>
                </div>
              </div>
            </div>
            @endif
          @endforeach
          --
        </div>
        @endif
      @endforeach
        
    </div>

@endsection
