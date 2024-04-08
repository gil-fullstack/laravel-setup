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
          <form method="POST" action={{url('cms/categoria_produto_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{isset($categoria) ? $categoria->id : ''}}">
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Título</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="titulo" value="{{isset($categoria) ? $categoria->titulo : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Imagem Destaque</strong></label>
              <div class="col-sm-10 container_imagem_destaque_form">
                <input class="form-control upload_imagem_destaque" type="file" name="imagem_destaque" value="blocked" style="display:{{isset($categoria) ? ($categoria->imagem_destaque ? 'none' : 'block') : 'block'}}">
                @isset($categoria)
                  @if($categoria->imagem_destaque)
                    <input class="form-control imagem_destaque_form upload_imagem_destaque" type="hidden" name="imagem_destaque" value="blocked">
                  <img src="{{asset('storage/'.$categoria->imagem_destaque)}}" alt="" width="200" class="imagem_destaque_form">
                  @endif
                @endisset
                <button type="button" class="btn btn-danger btn_apagar_imagem_destaque_form {{isset($categoria) ? ($categoria->imagem_destaque ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Destaque</strong></label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-sim" value="1" {{isset($categoria) ? ($categoria->destaque == 1 ? 'checked' : '') : ''}}>
                <label class="form-check-label" for="destaque-sim">Sim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-nao" value="0" {{isset($categoria) ? ($categoria->destaque == 0 ? 'checked' : '') : 'checked'}}>
                <label class="form-check-label" for="destaque-nao">Não</label>
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
          <button type="button" name="banner" class="btn btn-primary btn-sm tipo-imagem m-2" title="Banner">Banner - 1920x980</button>
          <button type="button" name="secundaria_banner" class="btn btn-primary btn-sm tipo-imagem m-2" title="Imagem Secundária do Banner">Imagem Secundária do Banner - 400x400</button>
          <button type="button" name="cta" class="btn btn-primary btn-sm tipo-imagem m-2" title="CTA">CTA - 1440x250</button>
          <button type="button" name="detalhe_produto" class="btn btn-primary btn-sm tipo-imagem m-2" title="Detalhe de produto">Detalhe de produto - 600x800</button>
          <button type="button" name="logo_site" class="btn btn-primary btn-sm tipo-imagem m-2" title="Logo do site">Logo do site - 280x70</button>
          <button type="button" name="outro" class="btn btn-primary btn-sm tipo-imagem m-2" title="Personalizado">Outro - 1280x720</button>
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
