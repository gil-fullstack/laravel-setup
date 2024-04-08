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
              <h3 class="mb-0">{{isset($conteudo) ? 'Editar' : 'Adicionar'}} Conteúdo</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <form method="POST" action={{url('cms/conteudo_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{isset($conteudo) ? $conteudo->id : ''}}">
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Título</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="titulo" value="{{isset($conteudo) ? $conteudo->titulo : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Descrição</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="descricao" value="{{isset($conteudo) ? $conteudo->descricao : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Texto</strong></label>
              <div class="col-sm-10">
                <textarea id="editor" name="texto">{{isset($conteudo) ? $conteudo->texto : ''}}</textarea>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Imagem</strong></label>
              <div class="col-sm-10 container_imagem_form">
                <input class="form-control upload_imagem" type="file" name="imagem" value="blocked" style="display:{{isset($conteudo) ? ($conteudo->imagem ? 'none' : 'block') : 'block'}}">
                @isset($conteudo)
                  @if($conteudo->imagem)
                  <input class="form-control imagem_form upload_imagem" type="hidden" name="imagem" value="blocked">
                  <img src="{{asset('storage/'.$conteudo->imagem)}}" alt="" width="200" class="imagem_form">
                  @endif
                @endisset
                <button type="button" class="btn btn-danger btn_apagar_imagem_form {{isset($conteudo) ? ($conteudo->imagem ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
              </div>

            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Imagem Responsiva</strong></label>
              <div class="col-sm-10 container_imagem_responsiva_form">
                <input class="form-control upload_imagem_responsivo" type="file" name="imagem_responsiva" value="blocked" style="display:{{isset($conteudo) ? ($conteudo->imagem_responsiva ? 'none' : 'block') : 'block'}}">
                @isset($conteudo)
                  @if($conteudo->imagem_responsiva)
                    <input class="form-control imagem_destaque_form upload_imagem_responsivo" type="hidden" name="imagem_responsiva" value="blocked">
                  <img src="{{asset('storage/'.$conteudo->imagem_responsiva)}}" alt="" width="200" class="imagem_destaque_form">
                  @endif
                @endisset
                <button type="button" class="btn btn-danger btn_apagar_imagem_responsiva_form {{isset($conteudo) ? ($conteudo->imagem_responsiva ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Link</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="link" value="{{isset($conteudo) ? $conteudo->link : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Arquivo</strong></label>
              <div class="col-sm-10 container_arquivo_form">
                <input class="form-control" type="file" name="arquivo" value="blocked" style="display:{{isset($conteudo) ? ($conteudo->arquivo ? 'none' : 'block') : 'block'}}">
                @isset($conteudo)
                  @if($conteudo->arquivo)
                  <input class="form-control arquivo_form" type="hidden" name="arquivo" value="blocked">
                  <a href="{{url('storage/'.$conteudo->arquivo)}}" class="arquivo_form" target="_blank">{{url('storage/'.$conteudo->arquivo)}}</a>
                  <button type="button" class="btn btn-danger btn_apagar_arquivo_form" name="button"><i class="fas fa-trash"></i></button>
                  @endif
                @endisset
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Destaque</strong></label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-sim" value="1" {{isset($conteudo) ? ($conteudo->destaque == 1 ? 'checked' : '') : ''}}>
                <label class="form-check-label" for="destaque-sim">Sim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-nao" value="0" {{isset($conteudo) ? ($conteudo->destaque == 0 ? 'checked' : '') : 'checked'}}>
                <label class="form-check-label" for="destaque-nao">Não</label>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Página</strong></label>
              <div class="col-sm-10">
                <select class="form-control" name="pagina_id">
                  @foreach ($paginas as $key => $item)
                    <option value="{{$item->id}}" {{isset($conteudo) ? ($conteudo->pagina_id == $item->id ? 'selected' : '') : ''}}>{{$item->titulo}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="sendmail" value="1" id="sendmail">
              <label class="form-check-label" for="sendmail">Enviar email informativo (Somente para notícias)</label>
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
