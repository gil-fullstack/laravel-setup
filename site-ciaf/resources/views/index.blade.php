@extends('layouts/master')
@section('content')

<div id="banner" class="carousel slide carousel-fade" data-ride="carousel" data-interval="{{$intervalo_banner ? $intervalo_banner->valor : '5000'}}">
  <div class="carousel-inner h-100">
    @foreach ($conteudo as $key => $item)

      <div class="carousel-item {{$key == 0 ? 'active' : ''}} h-100" style="background-image:url({{asset('storage/'.$item->imagem)}}); background-size:cover; background-position:center;">
        @if($item->link != '' && $item->link != null)
          <a href="{{$item->link}}" style="">
        @endif
          <div class="overlay"></div>
          <div class="container h-100 d-flex align-items-center texto-banner">
            <div class="row align-items-center h-100">
              <div class="col-md-6 col-12 bounce-in-left item-1">
                <h1 class="mb-2">{!!$item->titulo!!}</h1>
                <h2 class="mb-4" style="font-family:'Open Sans', Arial, sans-serif; font-weight:200; font-size:14pt;">{!!$item->descricao!!}</h2>
                {{-- <button type="button" name="button" class="btn btn-custom btn-cta">Ligamos pra você</button> --}}
              </div>
              <div class="col-md-6 d-none d-md-block bounce-in-right item-2 {{$item->destaque == 1 ? 'align-self-end' : ''}}">
                <img src="{{asset('storage/'.$item->imagem_responsiva)}}" class="img-fluid" alt="" style="{{$item->destaque == 1 ? 'min-width:400px' : ''}}">
              </div>
            </div>
          </div>
        @if($item->link != '' && $item->link != null)
          </a>
        @endif
      </div>

    @endforeach
  </div>
  <a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#banner" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Próximo</span>
  </a>

  <div class="arrow">
    <a href="#solucoes"><i class="fas fa-chevron-circle-down"></i></a>
  </div>
</div>

<div class="container" id="solucoes" style="padding-top:100px; padding-bottom:80px">

  <div>
    <h2 class="title">Soluções</h2>
    <hr>
  </div>

  <div class="owl-carousel owl-theme">
    @foreach ($produtos as $key => $item)
      <div class="card h-100">
        <img src="{{asset('storage/'.$item->imagem_destaque)}}" class="card-img-top" alt="{{$item->titulo}}" height="60" style="width:auto !important">
        <div class="card-body">
          <h5 class="card-title">{{$item->titulo}}</h5>
          <p class="card-text">{{$item->descricao}}</p>
        </div>
        <div class="card-footer text-center">
          <a href="{{url('solucoes/'.$item->id)}}" class="btn btn-custom-2">Saiba Mais</a>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="carousel slide cta mb-5">
  <div class="carousel-inner">
    <div class="carousel-item active d-flex justify-content-center align-items-center flex-column" style="background-image:url({{asset('storage/'.$cta->imagem)}}); background-size:cover; background-position:center; height:250px">
      <div class="overlay"></div>
      <div class="text-center position-relative container">
        <h3 class="mb-3">{{$cta->titulo}}</h3>
        <p class="mb-4">{{$cta->descricao}}</p>
        <button type="button" name="button" class="btn btn-custom btn-cta">Ligue para mim</button>
      </div>

    </div>
  </div>
</div>

@if($noticias->count() > 0)
<div class="container text-center" id="noticias">
  <div>
    <h2 class="title text-left">Notícias</h2>
    <hr>
  </div>
  <div class="row row-cols-1 row-cols-md-4 justify-content-center">
    @foreach ($noticias as $key => $item)
      <div class="col mb-4">
        <div class="card h-100">
          <div class="card-header">
            <small class="text-muted">{{$item->created_at->locale('pt-BR')->isoFormat('D \d\e MMMM \d\e Y')}}</small>
          </div>
          <div class="card-body">
            <h5 class="card-title">{{$item->titulo}}</h5>
            <p class="card-text descricao">{{$item->descricao}}</p>
          </div>
          <div class="card-footer text-center">
            <a href="{{url('noticias_detalhes/'.$item->id)}}" class="btn btn-custom-2">Leia Mais</a>
          </div>
        </div>
      </div>
    @endforeach

  </div>
  <a href="{{url('noticias')}}" class="btn btn-primary text-center" style="background-color:#0074AD; border-color: #0074AD;">Ver todas as notícias</a>

</div>
@endif

<div class="modal fade" tabindex="-1" id="popup-exit" aria-labelledby="popup-exit" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        <img src="{{asset('storage/images/tech-banner.jpg')}}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Não vá embora ainda...</h5>
          <p class="card-text">Deixe seu contato e a gente te liga.</p>

          <form action="{{url('salvarcontato')}}" method="POST">
            @csrf
            <div class="form-group">
              <input type="text" name="nome" required="" placeholder="Nome" class="form-control" value={{old('nome')}}>
            </div>
            <div class="form-group">
              <input type="email" name="email" required="" placeholder="Email" class="form-control" value={{old('email')}}>
            </div>
            <div class="form-group">
              <input name="telefone" required="" placeholder="Telefone/Celular" class="form-control phone" value={{old('telefone')}}>
            </div>
            <input type="hidden" name="leave" value="1">
            <input type="hidden" name="assunto" value="Me liga">
            <input type="hidden" name="texto" value="">
            <input type="hidden" name="onde" value="8">
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
              {!! app('captcha')->display() !!}
              @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block text-danger">
                      <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
              @endif
          </div>
            <button type="submit" name="button" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Enviar</button>
            <a href="#" class="btn btn-secondary close-popup-exit" data-dismiss="modal">Cancelar</a>
          </form>
        </div>

    </div>
  </div>
</div>

@if ($errors->has('g-recaptcha-response'))
  <script>
    $('#popup-exit').modal('show');
  </script>
@endif



@endsection
