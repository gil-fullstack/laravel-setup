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
      <div class="row">
        <div class="col-12 col-md-8">
          <a href="{{url('dadospessoais')}}" class="btn btn-custom-2 m-2"><i class="fas fa-user mr-2"></i>Meus dados</a>
          <a href="{{url('logout_area_cliente')}}" class="btn btn-custom-2 m-2"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
          <h4 class="font-weight-bold">Bem-vindo, {{$cliente->nome}}.</h4>
          <pre>{{$cliente->chave}}</pre>
          <br>
          <br>
          <h6>Data de cadastro: {{Carbon\Carbon::createFromFormat('Y-m-d',$cliente->dt_cadastro)->format('d/m/Y')}}</h6>
          <h6>Sistema: <span style="text-transform:uppercase;">{{$cliente->categoria}}</span></h6>
          <hr style="border-top: 3px double #8c8b8b;">
          <br>
          <div class="clearfix">
            <h4 class="pull-left"><strong>Passo-a-passo para validar o sistema</strong></h4>
          </div>
          <br>
          <p>1) Ao carregar o CIAF clique em <strong>Diversos &gt; Efetivação do sistema ou Renovação de Licença</strong>;</p>
          <p>2) Clique em <strong>Efetivação de compra ou Renovação</strong> da sua versão;</p>
          <p>3) Confira a <strong>data da chave com a data que consta acima</strong> e altere se necessário;</p>
          <p>4) Digite cuidadosamente o nome para licenciamento <span style="text-transform:uppercase;"><strong>({{$cliente->nome}})</strong></span> com o <strong>"Caps Lock"</strong> do teclado ligado. <strong>A tecla "Tab" e seu mouse não devem ser utilizados.</strong> Ao final da digitação, basta <strong>pressionar "Enter"</strong>;</p>
          <p>5) <strong>A chave pode ser colada. Já o nome da empresa (Licenciar para) tem de ser digitado</strong>;</p>
          <p>6) Clique no botão <strong>OK</strong>;</p>
          <p>7) Após estes procedimentos, <strong>o CIAF será reiniciado</strong> para realizar a efetivação. Feito isso, basta <strong>abrir novamente</strong>.</p>
        </div>
        <div class="col-12 col-md-4">
          <h4>Notícias</h4>
          <div class="list-group">
            @foreach ($noticias as $key => $item)
              <a href="{{url('noticias_detalhes/'.$item->id)}}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{$item->titulo}}</h5>
                </div>
                <p class="text-muted mb-1">{{$item->descricao}}</p>
                <small class="text-muted">{{$item->created_at->locale('pt-BR')->isoFormat('D \d\e MMMM \d\e Y')}}</small>
              </a>
            @endforeach
            <a href="{{url('noticias')}}" class="mt-2">Mais notícias</a>
          </div>
        </div>
      </div>
    </div>

@endsection
