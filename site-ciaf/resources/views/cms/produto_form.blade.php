@extends('cms/master')
@section('content')
<link href="{{ asset('css/bootree.min.css') }}" rel="stylesheet">
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
              <h3 class="mb-0">{{isset($produto) ? 'Editar' : 'Adicionar'}} Produto</h3>
            </div>

          </div>
        </div>
        <div class="container">
          <input type="hidden" id="func_selecionadas" value="{{isset($produto->funcionalidades_selecionadas) ? $produto->funcionalidades_selecionadas : ''}}">
          <form id="form" method="POST" action={{url('cms/produto_salvar')}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id_produto" name="id" value="{{isset($produto) ? $produto->id : ''}}">
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Título</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="titulo" value="{{isset($produto) ? $produto->titulo : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Descrição</strong></label>
              <div class="col-sm-10">
                <input class="form-control" placeholder="Digite aqui" name="descricao" value="{{isset($produto) ? $produto->descricao : ''}}">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Detalhes</strong></label>
              <div class="col-sm-10">
                <textarea id="editor1" name="detalhes">{{isset($produto) ? $produto->detalhes : ''}}</textarea>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Texto</strong></label>
              <div class="col-sm-10">
                <textarea id="editor" name="texto">{{isset($produto) ? $produto->texto : ''}}</textarea>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Imagem</strong></label>
              <div class="col-sm-10 container_imagem_form">
                <input class="form-control upload_imagem" type="file" name="imagem" value="blocked" style="display:{{isset($produto) ? ($produto->imagem ? 'none' : 'block') : 'block'}}">
                @isset($produto)
                  @if($produto->imagem)
                  <input class="form-control imagem_form upload_imagem" type="hidden" name="imagem" value="blocked">
                  <img src="{{asset('storage/'.$produto->imagem)}}" alt="" width="200" class="imagem_form">
                  @endif
                @endisset
                <button type="button" class="btn btn-danger btn_apagar_imagem_form {{isset($produto) ? ($produto->imagem ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Imagem Destaque</strong></label>
              <div class="col-sm-10 container_imagem_destaque_form">
                <input class="form-control upload_imagem_destaque" type="file" name="imagem_destaque" value="blocked" style="display:{{isset($produto) ? ($produto->imagem_destaque ? 'none' : 'block') : 'block'}}">
                @isset($produto)
                  @if($produto->imagem_destaque)
                    <input class="form-control imagem_destaque_form upload_imagem_destaque" type="hidden" name="imagem_destaque" value="blocked">
                  <img src="{{asset('storage/'.$produto->imagem_destaque)}}" alt="" width="200" class="imagem_destaque_form">
                  @endif
                @endisset
                <button type="button" class="btn btn-danger btn_apagar_imagem_destaque_form {{isset($produto) ? ($produto->imagem_destaque ? '' : 'd-none') : 'd-none'}}" name="button"><i class="fas fa-trash"></i></button>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Arquivo</strong></label>
              <div class="col-sm-10 container_arquivo_form">
                <input class="form-control" type="file" name="link_download" value="blocked" style="display:{{isset($produto) ? ($produto->link_download ? 'none' : 'block') : 'block'}}">
                @isset($produto)
                  @if($produto->link_download)
                  <input class="form-control arquivo_form" type="hidden" name="link_download" value="blocked">
                  <a href="{{url('storage/'.$produto->link_download)}}" class="arquivo_form" target="_blank">{{url('storage/'.$produto->link_download)}}</a>
                  <button type="button" class="btn btn-danger btn_apagar_arquivo_form" name="button"><i class="fas fa-trash"></i></button>
                  @endif
                @endisset
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Destaque</strong></label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-sim" value="1" {{isset($produto) ? ($produto->destaque == 1 ? 'checked' : '') : ''}}>
                <label class="form-check-label" for="destaque-sim">Sim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="destaque" id="destaque-nao" value="0" {{isset($produto) ? ($produto->destaque == 0 ? 'checked' : '') : 'checked'}}>
                <label class="form-check-label" for="destaque-nao">Não</label>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label class="col-sm-2 col-form-label"><strong>Categoria do Produto</strong></label>
              <div class="col-sm-10">
                <select class="form-control" name="categoria_produtos_id">
                  @foreach ($categoria_produtos as $key => $item)
                    <option value="{{$item->id}}" {{isset($produto) ? ($produto->categoria_produtos_id == $item->id ? 'selected' : '') : ''}}>{{$item->titulo}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <h1>Funcionalidades</h1>

            <div class="row">
           
              <div class="col-md-4">
                <label class="col-form-label"><strong>Arvores</strong></label>
                <select class="form-control" id="arvores_totais" name="arvores_totais">
                  <option value="" selected>Selecione uma arvore</option>
                  @foreach ($json_arvore as $key => $item)
                    <option value="{{$item->id}}">{{$item->nome}}</option>
                  @endforeach
                </select>
              </div>
  
              @if (isset($produto_arvore))
                  
                <div class="col-md-4">
                  <label class="col-form-label"><strong>Arvores cadastrada nesse produto</strong></label>
                  <select class="form-control" id="arvores_atribuidas">
                    @if ($produto_arvore->isEmpty())
                        <option value="">Nenhuma arvore atribuida a esse produto</option>
                    @else
                    <option value="">Selecione um item</option>
                      @foreach ($produto_arvore as $key => $item)
                          
                        <option value="{{$item->id}}" {{$loop->index == 0 ? "selected" : ''}}>{{$item->nome}}</option>
                        
                      @endforeach
    
                    @endif
                  </select>
                </div>

              @endif

              <div class="col-md-4" style="display: flex;align-items: flex-end;">
                <button type="button" onclick="remover_arvore();" class="btn btn-danger btn-block">Remover</button>
              </div>

              <div class="col-md-12 mt-5">
                <div id="tree"></div>
              </div>
              <div id="alerta" class="col-md-12 d-none">
                <div class="alert alert-primary" role="alert">
                Arvore não cadastrada, adicione uma antes entrando <a href="{{url('cms/arvore')}}">nesse link</a>
                </div>
              </div>
              <input type="hidden" id="input_arvore" name='arvore_nodes' value="">
  
              <div class="form-group mt-5">
                <button type="button" onclick="submit_func();" class="btn btn-primary btn-block">Salvar</button>
              </div>
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
<script src="{{ asset('js/bootree.min.js') }}"></script>
<script>
  let json = [];
  let tree;
  let selecionado = $('#func_selecionadas').val();
  let arvore_selecionada;
  let id_produto = $('#id_produto').val();
  // console.log(selecionado);
  let array_selecionado;
  $.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

  });

  function remover_arvore(){
    let arvore_cadastrada_selecionada = $('#arvores_atribuidas').val();
    
    if(arvore_cadastrada_selecionada == ''){

      Swal.fire({
          icon: 'error',
          title: 'ops!!',
          text: 'Selecione uma arvore cadastrada para ser removida!',
      });

    }else{
      $.ajax({
        
        type:'POST',

        url:`{{Route('remover.arvore_atribuida')}}`,
        data: {
          id_arvore: arvore_cadastrada_selecionada,
          id_produto: id_produto
        },

        success:function(data){
          // console.log(data);

          if(data){

            Swal.fire({
              icon: 'success',
              title: 'Tudo certo!!',
              text: 'Arvore removida com sucesso!',
            });

          }else{

            Swal.fire({
              icon: 'error',
              title: 'ops!!',
              text: 'Tivemos um erro para remover esta arvore!',
            });

          }
          window.location.reload();

        }

      });
    }

  }

  function submit_func(){
    
    if ($("#arvores_totais").val() != "") {
    
      let nodes_selecionados = tree.getCheckedNodes();
      $('#input_arvore').val(JSON.stringify(nodes_selecionados));
      
    }

    $('#form').submit();
  }

  function buscar_adicionar_node(id, obj_json){
      let type = typeof obj_json;
      if(type == "object"){
          
          if(obj_json.id != undefined){
              
              if(obj_json.id == id){
                  obj_json.checked = true;
                  return '';
              }

          }

          for (let key in obj_json) {
              
              buscar_adicionar_node(id, obj_json[key]);

          }

      }
  }

  $("#arvores_totais").change(function(){
  
    arvore_selecionada = $(this).val();
    
    if(id_produto == ''){

      $.ajax({
        
        type:'POST',

        url:`{{Route('get_json.arvore')}}`,
        data: {
          id: arvore_selecionada,
        },

        success:function(data){
            console.log(data);
            if(data['json'] != undefined){

              json = JSON.parse(data['json']);
              if(selecionado != ''){

                $(array_selecionado).each(function(index, valor){
                  buscar_adicionar_node(valor, json);
                });
                
              }
              $('#tree').tree().destroy();
              tree = $('#tree').tree({
                  primaryKey: 'id',
                  uiLibrary: 'fontawesome',
                  dataSource: json,
                  checkboxes: true,
              });

            }else{
              $('#alerta').removeClass('d-none');
            }

        }

      });

    }else{

      $.ajax({
        
        type:'POST',

        url:`{{Route('produto_json_arvore')}}`,
        data: {
          id: arvore_selecionada,
          id_produto: id_produto
        },

        success:function(data){
            let arvore = data['arvore'];
            let produto_arvore = data['produto_arvore'];
            // console.log(arvore);
            // console.log(produto_arvore);
            if(arvore['json'] != undefined){

              json = JSON.parse(arvore['json']);

              if(produto_arvore != null){

                array_selecionado = JSON.parse(produto_arvore['funcionalidades_selecionadas'].replace(/'/g, '"'));
                $(array_selecionado).each(function(index, valor){
                  buscar_adicionar_node(valor, json);
                });
                
              }
              $('#tree').tree().destroy();
              tree = $('#tree').tree({
                  primaryKey: 'id',
                  uiLibrary: 'fontawesome',
                  dataSource: json,
                  checkboxes: true,
              });

            }else{
              $('#alerta').removeClass('d-none');
            }

        }

      });

    }

  });

  $(document).ready(function(){

    if(selecionado != ''){
      
      array_selecionado = JSON.parse(selecionado.replace(/'/g, '"'));

    }
    // console.log(array_selecionado);
    // $('#tree').tree().destroy();

      $.ajax({
      
        type:'GET',
  
        url:`{{Route('get_json.arvore')}}`,
  
        success:function(data){
            // console.log(data['json']);
            if(data['json'] != undefined){

              json = JSON.parse(data['json']);
              if(selecionado != ''){

                $(array_selecionado).each(function(index, valor){
                  buscar_adicionar_node(valor, json);
                });
                
              }
              tree = $('#tree').tree({
                  primaryKey: 'id',
                  uiLibrary: 'fontawesome',
                  dataSource: json,
                  checkboxes: true,
              });

            }else{
              $('#alerta').removeClass('d-none');
            }
  
        }
  
      });

  });
</script>

@endsection
