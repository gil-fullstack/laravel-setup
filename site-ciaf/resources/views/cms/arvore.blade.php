@extends('cms/master')
@section('content')
{{-- <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
<link href="{{ asset('css/bootree.min.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row">
            <h1>Funcionalidades Lista</h1>
        </div>
        <div class="row" style="border-radius: 10px;border: solid 1px #00000038;display: flex;align-items: center;padding: 10px;">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nome_item">Nome da arvore</label>
                    <input type="text" class="form-control" id="nome_arvore" placeholder="nome do item">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome_item">Adicionar Item</label>
                    <input type="text" class="form-control" id="nome_item" placeholder="nome do item">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="check_sub_menu">
                    <label class="form-check-label" for="check_sub_menu">Sub-menu</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="select_pai">Selecione o menu pai</label>
                    <select class="form-control" disabled id="select_pai">
                        <option value="0" selected>Selecione um dos item</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end">
                <button type="button" onclick="remover_node();" class="btn btn-danger">Remover</button>
                <button type="button" onclick="adicionar_node();" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
        <div class="row mt-5" style="border-radius: 10px;border: solid 1px #00000038;display: flex;align-items: center;padding: 10px;">
            <div class="col-md-12">
                <h5>Arvore de funcionalidades</h5>
            </div>
            <div class="col-md-12">
                <div id="alert" class="alert alert-primary" role="alert">
                    Arvore vazia
                </div>
                <div id="tree"></div>
            </div>
            <div class="col-md-12">
                <button type="button" onclick="salvar_json();" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
  <script src="{{ asset('js/bootree.min.js') }}"></script>
    <script type="text/javascript">
        let select_form = $('#select_pai');
        let last_id = 0;
        let json = [];
        let tree;
        let node_corrente_check_ordenacao;
        function remover_node(){
            
            if(json.length == 0){

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Arvore está vazia!',
                });

            }else{

                let nodes_selecionados = tree.getCheckedNodes();
                // alert(nodes_selecionados);
                $(nodes_selecionados).each(function(index, valor){
                    bt.tree.methods.removeDataById(tree, valor, json);
                });
                        
    
                // console.log(json);
                $('#tree').tree().destroy();
                tree = $('#tree').tree({
                    primaryKey: 'id',
                    uiLibrary: 'fontawesome',
                    dataSource: json,
                    checkboxes: true
                });
                $(select_form).empty();
                js_traverse(json);

            }


        }

        function adicionar_node(){
                       
            let select_val = select_form.val();
            let nome_menu = $('#nome_item').val();

            if(!nome_menu){

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nome não pode ser vazio!',
                });
            
            }else{

                if(select_val == '0' && $('#check_sub_menu').is(':checked')){

                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Não pode adicionar um sub-menu sem um menu pai, por favor selecione um item antes!',
                    });
                
                }else if(select_val != '0' && $('#check_sub_menu').is(':checked')){

                    let result = buscar_adicionar_node(select_val, json, nome_menu, last_id);
                    
                }else{
                    
                    let obj_json_add = {
                        id: last_id + 1,
                        text: nome_menu,
                        children: [],
                        checked: false,
                    };
                    json.push(obj_json_add);
                    let novo_array = json.sort(function(a, b){
                        if(a.text < b.text) return -1;
                        if(a.text > b.text) return 1;
                        return 0;
                    });
                    json = novo_array;
                    
                }
                $('#tree').tree().destroy();
                tree = $('#tree').tree({
                    primaryKey: 'id',
                    uiLibrary: 'fontawesome',
                    dataSource: json,
                    checkboxes: true
                });
                select_form.empty();
                js_traverse(json);
            }
            

        }

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        function salvar_json(){
            
            let nome_arvore = $("#nome_arvore").val();

            if(json.length == 0){

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Não pode salvar uma arvore vazia, adicione pelo menos um nó!',
                });

            }else if(nome_arvore == ""){

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Não pode salvar uma arvore sem adicionar um nome!',
                });

            }else{
                
                $.ajax({
    
                    type:'POST',
    
                    url:`{{Route('store.arvore')}}`,
    
                    data:{
                        json: JSON.stringify(json),
                        nome: nome_arvore
                    },
    
                    success:function(data){

                        Swal.fire({
                            icon: 'success',
                            title: 'Tudo certo!!',
                            text: 'Funcionalidades salvas com sucesso!',
                        });
                        window.location.href = "{{ url('cms/arvore/editar/')}}" + '/' + data['id'];
    
                    }
    
                });

            }

        }

        function buscar_adicionar_node(id, obj_json, nome, last){
            let type = typeof obj_json;
            if(type == "object"){
                
                if(obj_json.id != undefined){
                    
                    if(obj_json.id == id){

                        let obj_json_add = {
                            id: '',
                            text: '',
                            children: [],
                            checked: false,
                        };
                        last_id = parseInt(last) + 1;
                        obj_json_add.id = last_id;
                        obj_json_add.text = nome;
                        obj_json.children.push(obj_json_add);

                        let novo_array = obj_json.children.sort(function(a, b){
                            if(a.text < b.text) return -1;
                            if(a.text > b.text) return 1;
                            return 0;
                        });

                        obj_json.children = novo_array;
                        return '';
                    }

                }

                for (let key in obj_json) {
                    
                    buscar_adicionar_node(id, obj_json[key], nome, last);

                }

            }
        }

        function js_traverse(obj_json) {
            if(json.length > 0){
                $('#alert').addClass('d-none');
            }
            let type = typeof obj_json;
            if (type == "object") {

                if(obj_json.id != undefined && obj_json.text != undefined){
                    
                    select_form.append('<option value="' + obj_json.id + '">' + obj_json.text + '</option>');
                    
                    if(obj_json.id > last_id){

                        last_id = obj_json.id;
                    
                    }
                    
                }

                for (let key in obj_json) {
                    
                    js_traverse(obj_json[key]);

                }

            }
        }

        $('#check_sub_menu').click(function(){
            
            if($(this).is(':checked')){
                
                select_form.removeAttr('disabled');

            }else{

                select_form.attr('disabled', 'disabled');

            }

        });

        // $(document).ready(function () {

        //     $.ajax({
    
        //         type:'GET',

        //         url:`{{Route('get_json.arvore')}}`,

        //         success:function(data){
                    
        //             json = JSON.parse(data['json']);

        //             tree = $('#tree').tree({
        //                 primaryKey: 'id',
        //                 uiLibrary: 'fontawesome',
        //                 dataSource: json,
        //                 checkboxes: false
        //             });

        //             js_traverse(json);

        //         }

        //     });

        // });

</script>

@endsection