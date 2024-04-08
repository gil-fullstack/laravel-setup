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
              <h3 class="mb-0">Editar {{isset($configuracao) ? $configuracao->tipo : ''}}</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <form method="POST" action={{url('cms/configuracoes_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{isset($configuracao) ? $configuracao->id : ''}}">
            @if(is_numeric($configuracao->valor))
              <div class="form-group row align-items-center">
                <label class="col-sm-2 col-form-label"><strong>Valor</strong></label>
                <div class="col-sm-10">
                  <input class="form-control" placeholder="Digite aqui" name="valor" value="{{isset($configuracao) ? $configuracao->valor : ''}}" required>
                </div>
              </div>
            @else
              <div class="form-group row align-items-center">
                <label class="col-sm-2 col-form-label"><strong>Imagem</strong></label>
                <div class="col-sm-10 container_imagem_form">
                  <input class="form-control upload_imagem" type="file" name="valor" value="blocked" style="display:{{isset($configuracao) ? ($configuracao->valor ? 'none' : 'block') : 'block'}}">
                  @isset($configuracao)
                    @if($configuracao->valor)
                    <input class="form-control imagem_form upload_imagem" type="hidden" name="valor" value="blocked">
                    <img src="{{asset('storage/'.$configuracao->valor)}}" alt="" width="200" class="imagem_form">
                    @endif
                  @endisset
                  <button type="button" class="btn btn-danger btn_apagar_imagem_form {{isset($configuracao) ? ($configuracao->valor ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
                </div>
              </div>
            @endif

            <div class="form-group mt-5">
              <button type="submit" class="btn btn-primary btn-block">Salvar</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade image_uploader_modal" id="upload_image" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload de imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tipo-imagem-div">
          <h2>Qual tipo de imagem você quer subir?</h2>
          <button type="button" name="cta" class="btn btn-primary btn-sm tipo-imagem m-2" title="CTA">Banner - 1440x250</button>
        </div>
        <div class="tipo-imagem-escolhida" style="display:none">
          <h2></h2>
          <div id="image-crop"></div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="usar-imagem">Usar imagem</button>
      </div>
    </div>
  </div>
</div>
@endsection
