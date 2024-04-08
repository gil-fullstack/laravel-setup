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
              <h3 class="mb-0">{{isset($modelo) ? 'Editar' : 'Adicionar'}} Modelo</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <form method="POST" action={{url('cms/modelo_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{isset($modelo) ? $modelo->id : ''}}">
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Nome</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="nome" value="{{isset($modelo) ? $modelo->nome : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Produto</strong></label>
              <div class="col-sm-10">
                <select class="form-control" name="produto_id">
                  @foreach ($produtos as $key => $item)
                    <option value="{{$item->id}}" {{isset($modelo) ? ($modelo->produto_id == $item->id ? 'selected' : '') : ''}}>{{$item->titulo}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Categoria</strong></label>
              <div class="col-sm-10">
                <select class="form-control" name="categoria_id">
                  @foreach ($categorias as $key => $item)
                    <option value="{{$item->id}}" {{isset($modelo) ? ($modelo->categoria_id == $item->id ? 'selected' : '') : ''}}>{{$item->nome}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Preço (R$)</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Somente números" name="preco" type="text" value="{{isset($modelo) ? $modelo->preco : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Observação</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="obs" value="{{isset($modelo) ? $modelo->obs : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Tag 1</strong></label>
              <div class="col-sm-10">
                <textarea name="paypal" rows="8" cols="80" class="form-control">{{isset($modelo) ? $modelo->paypal : ''}}</textarea>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Tag 2</strong></label>
              <div class="col-sm-10">
                <textarea name="tag_2" rows="8" cols="80" class="form-control">{{isset($modelo) ? $modelo->tag_2 : ''}}</textarea>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Tag 3</strong></label>
              <div class="col-sm-10">
                <textarea name="tag_3" rows="8" cols="80" class="form-control">{{isset($modelo) ? $modelo->tag_3 : ''}}</textarea>
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
