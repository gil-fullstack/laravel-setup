@extends('layouts/master')
@section('content')
<link href="{{ asset('css/bootree.min.css') }}" rel="stylesheet">
<style>
  .selecionado{
    color: green!important;
    border-bottom: solid 1px #00000038;
  }
  .nao_selecionado{
    color: red!important;
    border-bottom: solid 1px #00000038;
  }
</style>

  <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
  
    <div class="carousel-inner h-100">
  
      <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
   
        <div class="overlay"></div>
        <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
        
          <h1 class="mt-5 mb-0">{{$categoria->titulo}}</h1>
          <hr style="border: 1px solid #CC1707; width:100px">
        
        </div>
   
      </div>
  
    </div>
  
  </div>

  <div class="container py-4">

    <p>{{$categoria->descricao}}</p>



   <div id="accordion">
      
      @foreach ($produtos as $produto)
        <div class="card" style="margin: 5px;">
          
            <div class="card-header" id="heading{{$produto->id}}">
              
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$produto->id}}" aria-expanded="true" aria-controls="collapse{{$produto->id}}">
                  <h4>{{$produto->titulo}}</h4>
                </button>
                <a href="{{url('solucoes_detalhes').'/'.$produto->id}}" style="float: right;display:flex;align-items:center;justify-content:space-around;" class="btn btn-custom "><i class="fas fa-plus"></i> Mais detalhes</a>
              
            </div>

            <div id="collapse{{$produto->id}}" class="collapse" aria-labelledby="heading{{$produto->id}}" data-parent="#accordion">
              <div class="card-body">
                @if (!$produto->arvores->isEmpty())                  
                  @foreach ($produto->arvores as $arvore)
                 
                      <div class="col-md-12" style="padding: 10px;border: solid 1px #0000001f;border-radius: 10px;margin-bottom: 1pc;">
                        <p style="margin: 0">{{$arvore->nome}}</p>
                        <input type="hidden" class="funcionalidades" value="{{$arvore->id.'-'.$produto->id}}">
                        <div id="tree{{$arvore->id.'-'.$produto->id}}"></div>
                      </div>
                  @endforeach
                
                @else
                  <div class="alert alert-primary" role="alert">
                    Nenhuma funcionalidade cadastrada ainda!
                  </div>
                @endif
              </div>
            </div>
          
        </div>
      @endforeach
    </div> 
  </div>

  <div class="carousel slide cta">

    <div class="carousel-inner">

      <div class="carousel-item active d-flex justify-content-center align-items-center flex-column" style="background-image:url({{asset('storage/'.$cta_produto->imagem)}}); background-size:cover; background-position:center; height:300px">
        
        <div class="overlay"></div>

        <div class="text-center position-relative container">

          <h3 class="mb-3">{{$cta_produto->titulo}}</h3>
          <hr style="border: 1px solid #CC1707">
          <button type="button" name="button" class="btn btn-custom btn-cta">Ligue para mim</button>
        
        </div>

      </div>

    </div>

  </div>
  <script src="{{ asset('js/bootree.min.js') }}"></script>
  <script>

  $.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

  });

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

  $(document).ready(function(){

    let funcionalidades_selecionadas = $('.funcionalidades');
    let busca = [];
    let val_func_split;
    let json = [];

    $(funcionalidades_selecionadas).each(function(index, valor){
      busca.push($(valor).val());
    });

    // console.log(busca);
    $.ajax({
      
      type:'POST',

      url:`{{Route('arvore_produto_json')}}`,
      data: {
        busca: busca
      },

      success:function(data){

          $(data).each(function(index, valor){
            console.log(valor['arvore']);
            json = JSON.parse(valor['arvore']['json']);
            val_func_split = valor['funcionalidades']['funcionalidades_selecionadas'].split('-');
            


              // console.log();
            $(JSON.parse(val_func_split[0])).each(function(index, valor){
              buscar_adicionar_node(valor, json);
            });

            $('#tree'+valor['busca']).tree({
                primaryKey: 'id',
                uiLibrary: 'fontawesome',
                dataSource: json,
                checkboxes: false,
            });

          });

        $('.selecionado').each(function(index, valor_campo){
          $(valor_campo).append(' <i class="fas fa-check"></i>');
        });

        $('.nao_selecionado').each(function(index, valor_campo){
          $(valor_campo).append(' <i class="far fa-times-circle"></i>');
        });

      }

    });


  });

</script>

@endsection