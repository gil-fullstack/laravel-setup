@extends('layouts/master')
@section('content')
    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
        <div class="carousel-inner h-100">

            <div class="carousel-item active h-100"
                style="background-image:url('{{asset('storage/'.$banner_pagina->valor)}}'); background-size:cover; background-position:center;">
                <div class="overlay"></div>
                <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
                    <h1 class="mt-5 mb-0">Você receberá informações em Breve</h1>
                    <hr style="border: 1px solid #CC1707; width:100px">
                    <a href="{{url('/')}}" class="btn btn-custom-2 mx-3">Voltar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- @if($produto->paypal != '')
      <div class="container d-flex justify-content-center mt-5">
          <div class="col-md-12 d-flex">
              <div class="col-md-6 d-flex align-items-center">
                  <p>Pague com cartão de crédito clicando no banner ao lado</p>
              </div>
              <div class="col-md-6 d-flex justify-content-flex-end">

                  {!!$produto->paypal!!}
              </div>
          </div>
      </div>
    @endif
    @if($produto->tag_2 != '')
      <div class="container d-flex justify-content-center mt-5">
          <div class="col-md-12 d-flex">
              <div class="col-md-6 d-flex align-items-center">
                  <p>Pague com cartão de crédito clicando no banner ao lado</p>
              </div>
              <div class="col-md-6 d-flex justify-content-flex-end">

                  {!!$produto->tag_2!!}
              </div>
          </div>
      </div>
    @endif
    @if($produto->tag_3 != '')
      <div class="container d-flex justify-content-center mt-5">
          <div class="col-md-12 d-flex">
              <div class="col-md-6 d-flex align-items-center">
                  <p>Pague com cartão de crédito clicando no banner ao lado</p>
              </div>
              <div class="col-md-6 d-flex justify-content-flex-end">

                  {!!$produto->tag_3!!}
              </div>
          </div>
      </div>
    @endif
    <div class="container">
        <hr>
    </div>
    @if(!$produto->paypal && !$produto->tag_2 && !$produto->tag_3)
<div>
     <div class="container mt-4">
        <div class="col-md-12 d-flex justify-content-center flex-wrap">
          @if($produto->paypal != '' || $produto->tag_2 != '' || $produto->tag_3 != '')
            <div class="col-md-12 d-flex justify-content-flex-start mb-4">
                <p>
                    Ou se preferir faça o déposito em uma das contas a seguir:
                </p>
            </div>
          @endif
          <div class="row">


            @foreach ($pagamento as $key => $item)
              <div class="col-md-6 row align-items-center justify-content-center">
                <div class="p-4 col-md-4">
                  <img class="img-fluid" src="{{asset('storage/'.$item->imagem)}}">
                </div>
                <div class="col-md-8">
                  {!!$item->texto!!}

                  <p style="font-size:12px;">Nome do favorecido: {{$item->descricao}}</p>
                </div>

              </div>
            @endforeach
          </div>

        </div>
    </div>
    <div class="container">
        <hr>
    </div>
    <div class="container">
        <div class="col-md-12 d-flex justify-content-start flex-wrap">
            <p style="font-size:12px;color:red">É obrigatório que o depósito/transferência seja alfanúmerico destacando a razão social e o CNPJ da sua empresa, facilitando assim a identificação de seu pagamento.</p>
            <p style="font-size:12px;">Após o pagamento via depósito/transferência, por gentileza, envie o comprovante e seu CNPJ para: financeiro@ciaf.com.br</p>
        </div>
    </div>
</div>
@endif -->

@endsection
