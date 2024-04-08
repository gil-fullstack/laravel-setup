<div class="footer-parent">
  <footer class="page-footer bg-dark pt-4">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-2 text-center p-3">
          <a href="{{url('/')}}">
            <img src="{{asset('storage/images/ciaf_logoWHITE.png')}}" height="40" alt="">
          </a>
        </div>
        <div class="col-12 col-md-2">
          <ul style="list-style-type:none">
            <li><h5>Soluções</h5></li>
            @foreach ($footer['produtos'] as $key => $item)
              <a href="{{url('solucoes/'.$item->id)}}"><li>{{$item->titulo}}</li></a>
            @endforeach
          </ul>
        </div>
        <div class="col-12 col-md-2">
          <ul style="list-style-type:none">
            <li><h5>Seções</h5></li>
            <a href="{{url('sobre')}}"><li>Sobre</li></a>
            <a href="{{url('noticias')}}"><li>Notícias</li></a>
            <a href="{{url('suporte')}}"><li>Suporte</li></a>
            <a href="{{url('contato')}}"><li>Contato</li></a>
          </ul>
        </div>
        <div class="col-12 col-md-2">
          <ul style="list-style-type:none">
            <li><h5>Links úteis</h5></li>
            @foreach ($footer['links_uteis'] as $key => $item)
              <a href="{{$item->link}}" target="_blank"><li>{{$item->titulo}}</li></a>
            @endforeach
          </ul>
        </div>
        <div class="col-12 col-md-4 mt-2 mb-5">
          <iframe src="{{$footer['tag_facebook']->link}}" width="340" max-width="100%" height="154" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
      </div>
    </div>
  </footer>

  <div class="footer p-3 text-center justify-content-around align-items-center d-flex flex-row flex-wrap">
    <ul class="social-icons pull-right mt-3 col-12 col-md-6">
      @foreach ($footer['redes_sociais'] as $key => $item)
        <li><a href="{{$item->link}}" target="_blank" title="{{$item->titulo}}"><i class="fab {{$item->descricao}}"></i></a></li>
      @endforeach
    </ul>
    <h6 class="p-0 mb-0 col-12 col-md-6"><small>CIAF - 2021. Todos os direitos reservados ®</small></h6>
  </div>

</div>
