@extends('cms/master')
@section('content')

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
              <h3 class="mb-0">{{isset($categoria) ? 'Editar' : 'Adicionar'}} Categoria</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <form method="POST" action={{url('cms/categoria_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{isset($categoria) ? $categoria->id : ''}}">
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Nome</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="nome" value="{{isset($categoria) ? $categoria->nome : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Descrição</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="descricao" value="{{isset($categoria) ? $categoria->descricao : ''}}">
                <small>Adicione as tags @preco para preço e/ou faça fórmulas de divisão (Ex: @preco/12).</small>
              </div>
            </div>

            <div class="form-group mt-5">
              <button type="submit" class="btn btn-primary btn-block">Salvar</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
