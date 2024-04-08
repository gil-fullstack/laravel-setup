@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">CEP</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container text-center py-4">
      <div class="mb-4">
        <h4>Clique no estado para baixar o arquivo referente ao seu estado.</h4>
      </div>
      <div>
        <img src="images/mapaBrasil.jpg" alt="Mapa do Brasil" usemap="#Map">
        <map name="Map">
            <area shape="rect" coords="177,31,208,52" href="https://www.tvsistemas.com.br/download/ceps/CEPRR.zip">
            <area shape="rect" coords="139,131,169,152" href="https://www.tvsistemas.com.br/download/ceps/CEPAM.zip">
            <area shape="rect" coords="325,42,354,64" href="https://www.tvsistemas.com.br/download/ceps/CEPAP.zip">
            <area shape="rect" coords="45,208,75,226" href="https://www.tvsistemas.com.br/download/ceps/CEPAC.zip">
            <area shape="rect" coords="300,131,326,155" href="https://www.tvsistemas.com.br/download/ceps/CEPPA.zip">
            <area shape="rect" coords="160,229,190,250" href="https://www.tvsistemas.com.br/download/ceps/CEPRO.zip">
            <area shape="rect" coords="264,254,292,278" href="https://www.tvsistemas.com.br/download/ceps/CEPMT.zip">
            <area shape="rect" coords="421,142,453,162" href="https://www.tvsistemas.com.br/download/ceps/CEPMA.zip">
            <area shape="rect" coords="507,139,534,161" href="https://www.tvsistemas.com.br/download/ceps/CEPCE.zip">
            <area shape="rect" coords="556,153,581,175" href="https://www.tvsistemas.com.br/download/ceps/CEPRN.zip">
            <area shape="rect" coords="562,178,587,194" href="https://www.tvsistemas.com.br/download/ceps/CEPPB.zip">
            <area shape="rect" coords="531,197,554,212" href="https://www.tvsistemas.com.br/download/ceps/CEPPE.zip">
            <area shape="rect" coords="461,185,484,203" href="https://www.tvsistemas.com.br/download/ceps/CEPPI.zip">
            <area shape="rect" coords="374,225,401,243" href="https://www.tvsistemas.com.br/download/ceps/CEPTO.zip">
            <area shape="rect" coords="562,217,587,233" href="https://www.tvsistemas.com.br/download/ceps/CEPAL.zip">
            <area shape="rect" coords="547,234,572,251" href="https://www.tvsistemas.com.br/download/ceps/CEPSE.zip">
            <area shape="rect" coords="469,251,495,269" href="https://www.tvsistemas.com.br/download/ceps/CEPBA.zip">
            <area shape="rect" coords="374,294,400,314" href="https://www.tvsistemas.com.br/download/ceps/CEPDF.zip">
            <area shape="rect" coords="346,315,375,333" href="https://www.tvsistemas.com.br/download/ceps/CEPGO.zip">
            <area shape="rect" coords="427,343,461,363" href="https://www.tvsistemas.com.br/download/ceps/CEPMG.zip">
            <area shape="rect" coords="490,363,519,384" href="https://www.tvsistemas.com.br/download/ceps/CEPES.zip">
            <area shape="rect" coords="453,404,479,421" href="https://www.tvsistemas.com.br/download/ceps/CEPRJ.zip">
            <area shape="rect" coords="372,399,395,416" href="https://www.tvsistemas.com.br/download/ceps/CEPSP.zip">
            <area shape="rect" coords="281,369,309,388" href="https://www.tvsistemas.com.br/download/ceps/CEPMS.zip">
            <area shape="rect" coords="326,431,354,448" href="https://www.tvsistemas.com.br/download/ceps/CEPPR.zip">
            <area shape="rect" coords="345,469,375,489" href="https://www.tvsistemas.com.br/download/ceps/CEPSC.zip">
            <area shape="rect" coords="300,505,326,523" href="https://www.tvsistemas.com.br/download/ceps/CEPRS.zip">
        </map>
      </div>
    </div>

@endsection
