@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Ciaf Web</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container py-4">    
        
      <form method="POST" action="{{url('checkout2')}}" id="form_checkout">
        @csrf
        <div class="row">

          <div class="col-md-4 px-2">
            <div class="card p-3">
              <img src="{{asset('storage/'.$produto->imagem_destaque)}}" class="img-fluid">
              <div class="card-body">
                <h3 class="card-title"><strong>{{$produto->titulo}}</strong></h3>
                <div class="my-4">
                  <!-- <h6><strong>Escolha o tipo de contrato</strong></h6> -->

                  @foreach ($produto->precos->sortBy('categoria_id')->values() as $key => $item)
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="produto" id="{{'exampleRadios'.$key}}" value="5">
                      <!-- <label class="form-check-label" for="{{'exampleRadios'.$key}}">
                        @php
                          $dividendo = explode('/',$item->categoria->descricao);
                          if(isset($dividendo[1])){
                            $dividendo = explode(' ',$dividendo[1]);
                            $dividendo = $dividendo[0];
                            $modalidade = str_replace('@preco/'.$dividendo, '<strong>R$'.number_format($item->preco/$dividendo,2,',','').'</strong>', $item->categoria->descricao);
                            $modalidade = str_replace('@preco', '<strong>R$'.number_format($item->preco,2,',','').'</strong>', $modalidade);
                            $modalidade = str_replace($dividendo.'x de', '<strong>'.$dividendo.'x de</strong>', $modalidade);
                          }
                          else{
                            $modalidade = str_replace('@preco', '<strong>R$'.number_format($item->preco,2,',','').'</strong>', $item->categoria->descricao);
                          }
                        @endphp
                        {!!$modalidade!!}
                        {{-- @if($item->categoria_id == 1)
                          Plano anual: <strong>12x de R${{number_format($item->preco/12,2,',','')}}</strong> no cartão de crédito (total: R${{number_format($item->preco, 2, ',','')}})
                        @elseif($item->categoria_id == 2)
                          Plano anual: <strong>R${{number_format($item->preco,2,',','')}}</strong> à vista com 10% de desconto via depósito ou transferência
                        @elseif($item->categoria_id == 3)
                          Plano semestral: <strong>R${{number_format($item->preco,2,',','')}}</strong> à vista via depósito ou transferência
                        @endif --}}

                      </label> -->
                    </div>
                  @endforeach

                </div>
                <div class="text-left mt-3">
                  <!-- <a href="{{url('solucoes/'.$produto->categoria->id)}}" class="text-center my-3"><i class="fas fa-plus mr-2"></i><span>Ver funcionalidades</span></a> -->
                  <div class="collapse text-left mt-3" id="solucao_1">
                    @php
                      $funcionalidades_id = 0
                    @endphp
                    @foreach ($produto->roles()->orderBy('funcionalidades_id')->get() as $funcionalidade)
                      @if($funcionalidades_id != $funcionalidade->funcionalidades_id)
                        <a href="{{url('funcionalidades/'.$produto->id)}}" target="_blank">{{$funcionalidade->funcionalidade->descricao}}</a><br>
                      @endif
                      @php
                        $funcionalidades_id = $funcionalidade->funcionalidades_id;
                      @endphp
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 px-2">
            <div class="card p-3">
                <div class="mb-3">
                  <h5 class="mb-0"><strong>Preencha os campos com as suas informações</strong></h5>
                  <small class="text-muted">(*) Campos obrigatórios</small>
                </div>
                <div class="form-group">
                  <label>Seu nome*</label>
                  <input class="form-control" name="nome" min-length="4" required value="{{ old('nome') }}">
                </div>
                <div class="form-group">
                  <label>CPF/CNPJ*</label>
                  <input class="form-control cpf_cnpj" name="cnpj" required value="{{ old('cnpj') }}">
                </div>
                <div class="form-group">
                  <label>Razão Social*</label>
                  <input class="form-control razao_social" min-length="4" name="razao" required value="{{ old('razao') }}">
                </div>
                <div class="form-group">
                  <label>Nome Fantasia*</label>
                  <input class="form-control nome_fantasia" min-length="4" name="fantasia" required value="{{ old('fantasia') }}">
                </div>
                <div class="form-group">
                  <label>E-mail*</label>
                  <input class="form-control email" type="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label>Telefone*</label>
                  <input class="form-control phone telefone" name="telefone" required value="{{ old('telefone') }}">
                </div>
                <div class="form-group">
                  <label>Celular</label>
                  <input class="form-control phone" name="celular" value="{{ old('celular') }}">
                </div>                
                <div class="form-group">
                  <label>Número de Funcionários*</label>
                  <select class="form-control" name="funcionarios" required>
                    <option hidden value="">Selecione uma opção</option>
                    <option value="1">até 10</option>
                    <option value="2">11 a 50</option>
                    <option value="3">51 a 100</option>
                    <option value="4">Acima de 100</option>                                      
                  </select>
                </div>
                <div class="form-group">
                  <label>Média de Faturamento*</label>
                  <select class="form-control" name="faturamento" required>
                    <option hidden value="">Selecione uma opção</option>
                    <option value="1">até R$30.000,00 /mês</option>
                    <option value="2">R$31.000,00 a R$100.000,00</option>
                    <option value="3">Acima de R$100.000,00</option>                                                         
                  </select>
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
                  </select>
                </div>

                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                    {!! app('captcha')->display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                </div>

                <input type="hidden" id="validador" value="false">

                <button type="submit" class="d-none"></button>

                <button type="button" id="submit_form_checkout" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Enviar</button>

            </div>

          </div>
        </div>
      </form>
    </div>

@endsection
