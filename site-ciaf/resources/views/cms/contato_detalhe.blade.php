@extends('cms/master')
@section('content')

  @php
    $origem = [
      7 => 'Instagram',
      6 => 'Facebook',
      5 => 'Info Exame',
      1 => 'Pesquisa Google',
      2 => 'Indicação',
      4 => 'Superdownloads',
      3 => 'Baixaki',
      8 => 'Popup me liga'
    ];
  @endphp

<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0"></h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-4">
              <h3 class="mb-0">Contato</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Nome</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->nome}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Telefone</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->telefone}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Email</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->email}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Assunto</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->assunto}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Onde nos conheceu</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->onde ? $origem[$lead->onde] : ''}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Data</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{Carbon\Carbon::parse($lead->created_at)->format('d/m/Y H:i:s')}}</p>
            </div>
          </div>
          <div class="form-group row align-items-center">
            <label class="col-sm-2 col-form-label"><strong>Mensagem</strong></label>
            <div class="col-sm-10">
              <p class="mb-0">{{$lead->mensagem}}</p>
            </div>
          </div>
          <div class="pb-4">
            <a href="javascript:history.back()">Voltar</a>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection
