<nav class="navbar navbar-expand-md fixed-top bg-white" id="navbar">
  <a class="navbar-brand" href="{{url('/')}}">
    <img src="{{$navbar['logo'] ? asset('storage/'.$navbar['logo']->imagem) : ''}}" height="70" alt="" class="d-none d-md-block">
    <img src="{{$navbar['logo'] ? asset('storage/'.$navbar['logo']->imagem) : ''}}" height="50" alt="" class="d-block d-md-none">
  </a>
  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars text-dark fa-2x"></i>
  </button>

  <div class="collapse navbar-collapse flex-column" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto d-none d-md-flex" id="top-navbar">
      @foreach ($navbar['telefones'] as $key => $item)
      <li class="nav-item text-center mx-3 d-flex flex-column">
        <span class="text-muted titulo">{{$item->titulo}}</span>
        <a href="{{$item->link}}" class="descricao" target="_blank"><strong>{{$item->descricao}}</strong></a>
      </li>
      
      @endforeach
      <li class="nav-item text-center mx-3 d-flex flex-column">
        <iframe src="https://servidorseguro.mysuite.com.br/empresas/tvs/verificaseguro3.php" width="120" height="38" style="border:none"></iframe>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto align-items-md-center">
      <li class="nav-item dropdown mt-2">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Soluções
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{asset('solucoes_detalhes2/'.'14')}}">CIAF WEB</a>
          @foreach ($navbar['produtos'] as $key => $item)
            <a class="dropdown-item" href="{{asset('solucoes/'.$item->id)}}">{{$item->titulo}}</a>
          @endforeach

        </div>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('comprar')}}">Comprar</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('downloads')}}">Downloads</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('sobre')}}">Sobre</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('noticias')}}">Notícias</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('suporte')}}">Suporte</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{asset('contato')}}">Contato</a>
      </li>
      <li class="mr-2 ml-0 mt-2 mb-0 nav-item cliente">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle btn-sm p-2" style="background-color:#0074AD; border-color: #0074AD;" type="button" id="cliente" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Já sou cliente
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cliente">
            <a class="dropdown-item" href="{{url('login_cliente')}}">Área do cliente</a>
            <a class="dropdown-item" href="http://tvsistemas.mysuite.com.br/central.php" target="_blank">Abrir um chamado</a>
          </div>
        </div>
      </li>

      <div class="d-block d-md-none">
        <ul class="navbar-nav ml-auto">
          @foreach ($navbar['telefones'] as $key => $item)
            <li class="nav-item text-center mx-3 d-flex flex-column mb-1">
              <span class="text-muted titulo">{{$item->titulo}}</span>
              <a href="{{$item->link}}" class="descricao" target="_blank"><strong>{{$item->descricao}}</strong></a>
            </li>
          @endforeach
        </ul>
      </div>
    </ul>
  </div>
</nav>
