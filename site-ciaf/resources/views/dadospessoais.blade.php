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
      <div class="row mb-4">
        <a href="{{url('area_cliente')}}" class="btn btn-custom-2 m-2"><i class="fas fa-home mr-2"></i>Início</a>
        <a href="{{url('logout_area_cliente')}}" class="btn btn-custom-2 m-2"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <h2 class="title"><strong>Seus dados</strong></h2>
          <p><strong>Nome fantasia: </strong><span style="text-transform:uppercase;">{{$cliente->nome}}</span></p>
          <p><strong>Razão social: </strong><span style="text-transform:uppercase;">{{$cliente->razao}}</span></p>
          <p><strong>CEP: </strong>07242-380</p>
          <p><strong>Endereço: </strong><span style="text-transform:uppercase;">{{$cliente->endereco}}</span></p>
          <p><strong>Número: </strong>{{$cliente->numero}}</p>
          <p><strong>Bairro: </strong><span style="text-transform:uppercase;">{{$cliente->bairro}}</span></p>
          <p><strong>Cidade: </strong><span style="text-transform:uppercase;">{{$cliente->cidade}}</span></p>
          <p><strong>UF: </strong><span style="text-transform:uppercase;">{{$cliente->uf}}</span></p>
          <p><strong>País: </strong><span style="text-transform:uppercase;">{{$cliente->pais}}</span></p>
          <p><strong>Telefone: </strong>{{$cliente->fone1}}</p>
          <p><strong>Telefone 2: </strong>{{$cliente->fone2}}</p>
          <p><strong>Telefone 3: </strong>{{$cliente->fone3}}</p>
          <p><strong>CNPJ: </strong><span class="cnpj">{{$cliente->cnpj_cpf}}</span></p>
          <p><strong>Inscrição estadual: </strong>{{$cliente->ie}}</p>
          <p><strong>E-mail: </strong>{{$cliente->email}}</p>
          <br>
        </div>
        <div class="col-12 col-md-6">
          <h2 class="title"><strong>Mantenha seu cadastro sempre atualizado</strong></h2>
          <p>Informe algum destes dados para que possamos atualizar em nossa base de dados.</p>
          <form action="{{url('salvar_dados')}}" method="POST">
            @csrf
            <input type="hidden" name="nome" value="{{$cliente->nome}}">
            <input type="hidden" name="razao" value="{{$cliente->razao}}">
            <input type="hidden" name="cnpj_cpf" value="{{$cliente->cnpj_cpf}}">
            <div class="form-group">
              <label>CEP</label>
              <input class="form-control cep" placeholder="Somente números" name="cep">
            </div>
            <div class="form-group">
              <label>Endereço</label>
              <input class="form-control endereco" placeholder="Rua/Avenida/Travessa..." name="endereco">
            </div>
            <div class="form-group">
              <label>Número</label>
              <input class="form-control" placeholder="Número/complemento" name="numero">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input class="form-control bairro" placeholder="Bairro" name="bairro">
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <input class="form-control cidade" placeholder="Cidade" name="cidade">
            </div>
            <div class="form-group">
              <label>UF</label>
              <input class="form-control uf" placeholder="Somente a sigla do estado (Ex: SP, MG, ES, RJ)" name="uf">
            </div>
            <div class="form-group">
              <label>Telefone 1</label>
              <input class="form-control phone" placeholder="Somente números" name="fone1">
            </div>
            <div class="form-group">
              <label>Telefone 2</label>
              <input class="form-control phone" placeholder="Somente números" name="fone2">
            </div>
            <div class="form-group">
              <label>Telefone 3</label>
              <input class="form-control phone" placeholder="Somente números" name="fone3">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input class="form-control" type="email" placeholder="Email" name="email">
            </div>
            <button type="submit" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Enviar novos dados da empresa</button>
          </form>
        </div>
      </div>
    </div>

@endsection
