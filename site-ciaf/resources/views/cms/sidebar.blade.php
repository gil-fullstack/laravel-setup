@php
  $logo = App\Conteudo::where('pagina_id',17)->first();
@endphp

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="{{$logo ? asset('storage/'.$logo->imagem) : ''}}" class="navbar-brand-img" alt="...">
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{url('cms/conteudo')}}">
              <i class="ni ni-html5 text-orange"></i>
              <span class="nav-link-text">Conteúdo</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#produtoSubMenu" data-toggle="collapse" aria-expanded="false" class="nav-link">
              <i class="ni ni-cart text-danger"></i>
              <span class="nav-link-text">Produto</span>
            </a>
            <ul class="list-unstyled collapse" id="produtoSubMenu">
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/categoria_produto')}}">Categoria de Produtos</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/produto')}}">Produto</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/categoria')}}">Categoria de Modalidades</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/modelo')}}">Modelo</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/funcionalidades')}}">Funcionalidades</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/subfuncionalidades')}}">Sub-funcionalidades</a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#leadSubMenu" data-toggle="collapse" aria-expanded="false" class="nav-link">
              <i class="ni ni-single-02 text-success"></i>
              <span class="nav-link-text">Lead</span>
            </a>
            <ul class="list-unstyled collapse" id="leadSubMenu">
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/checkout')}}">Checkout</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/contato')}}">Contato</a>
                </li>
                <li class="nav-item ml-5 pb-2">
                  <a href="{{url('cms/download')}}">Download</a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('cms/configuracoes')}}">
              <i class="ni ni-settings text-primary"></i>
              <span class="nav-link-text">Configurações</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('cms/usuarios')}}">
              <i class="ni ni-key-25 text-primary"></i>
              <span class="nav-link-text">Usuários</span>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </div>
</nav>
