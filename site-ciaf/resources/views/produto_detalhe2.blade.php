@extends('layouts/master')
@section('content')
    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">CIAF WEB</h1>
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
          <h3 class="text-center">Ciaf Web</h3>
          <!-- <h3 style="font-weight:bold; font-size:12pt;" class="text-muted">{{$produto->descricao}}</h3> -->
          <h3 style="font-weight:bold; font-size:12pt;" class="text">Gerenciar o seu negócio, de forma fácil, simples e de qualquer lugar, é o que você sonha?</h3>
          <h3 style="font-weight:bold; font-size:12pt;" class="text-muted"> 	Com o Ciaf Web, a tecnologia e a inovação colaboram com o sucesso do empresário brasileiro.</h3>
              
            <div class="d-flex justify-content-center align-items-center my-3">
              <a href="{{url('checkout2/'.$produto->id)}}" class="btn btn-custom-2 mx-3">Informações</a>    
            </div>
          </form>
          <h4 style="font-size:12pt; font-weight:bold" class="text-muted">Detalhes</h4>
          <!-- {!!$produto->texto!!} -->
          <h3>Painel e Dashboard</h3>
          <p>Os dashboards permitem que você visualize e acompanhe indicadores e gráficos de maneira visual e prática, em apenas um painel de resultados.</p>
          <h3>Ferramentas de planejamento</h3>
          <p><b>Planejamento estratégico</b> é uma competência da administração que auxilia gestores a analisar seu 
            dia-a-dia e pensar no longo prazo de uma organização. Alguns itens e passos cruciais para o 
            plano estratégico são: missão, visão, objetivos, metas, criação de planos de ação e seu 
            posterior acompanhamento.</p>
            <p>Nossa plataforma possui duas ferramentas de planejamento estratégico,<b> Análise SWOT e Metas 5W2h</b>, 
            que podem ser usadas de forma simples e fácil.</p>
            <h4>Orçamentos, vendas e emissão de notas fiscais.</h4>
            <p>Sistema totalmente adequado para controle de orçamentos, vendas, emissão, 
              envio e gerenciamento da Notas Fiscais<b>(NFe – NFC-e – SAT e NFS-e).</b></p>
              <h4 >Boleto fácil, sem arquivo de remessa e retorno</h4>
              <p>Totalmente integrado, do envio ao controle de recebimentos, 
                <b>livre-se de custos fixos escondidos.</b> 
              </p>
              <p>Boletos não compensados, alterações e cancelamentos têm <b>custo zero.</b>
            </p>
            <h4>Integrações com E-commerces e Marketplaces</h4>
            <p>Captura pedidos, dados de clientes e produtos agilizando suas operações, realiza lançamentos financeiros e cadastros.</p>
            <p>Evite retrabalho, economize tempo  e aumente sua produtividade</p>
            <h4>Controle financeiro em suas mãos</h4>
            <p>	Módulo completo para que você possa ter um controle financeiro completo e não ter 
              surpresas inesperadas ao checar as finanças do seu negócio. Com tudo centralizado em 
              um única plataforma, você terá acesso, de onde estiver e quando quiser, aos dados 
              referentes ao seu contas a pagar, contas a receber, fluxo de caixa e muito mais.
            </p>
            <h4>Fluxo de caixa diário</h4>
            <p>Tenha o controle preciso do seu fluxo de caixa diário, acompanhe todas as movimentações
               financeiras, entradas e saídas, análise comportamentos e faça o monitoramento de possíveis
                oportunidades para o crescimento do seu negócio.
              </p>
              <h4>Conciliação Bancária </h4>
              <p>Reduz erros e trabalho na digitação e conferência de lançamentos financeiros.</p>
              <h4>Logística </h4>
              <p>Permite que as encomendas cheguem ao seu destino da forma mais eficiente, através de 
                integrações de pré-postagem, cotação de fretes e emissão etiquetas das encomendas.
              </p>             
              <div class="d-flex justify-content-center align-items-center my-3">
                    <a href="{{url('checkout2/'.$produto->id)}}" class="btn btn-custom-2 mx-3">Informações</a>    
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
