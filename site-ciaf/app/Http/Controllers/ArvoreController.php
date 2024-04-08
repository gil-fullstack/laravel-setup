<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arvore;
use App\Produto;
use App\ProdutoArvore;

class ArvoreController extends Controller{
    
    protected $pai = [];
    protected $json_obj = [];
    protected $json_temp = [];
    protected $nodes_visitados = [];
    public function index(){

        return view('cms/arvore');
    }

    public function listar_arvores(){

        $arvores = Arvore::get();

        return view('cms/listar_arvore', compact('arvores'));

    }

    public function get_json(Request $request){

        return $json_arvore = json_decode(Arvore::select('json')->find($request->id), true);
    
    }

    public function get_json_arvore_produto(Request $request){

        return $json_arvore = json_decode(Arvore::select('json')->find($request->id), true);
    
    }

    public function percorrer_json($json){
        
        foreach ($json as $valor) {

            if (isset($valor["children"])) {
                
                if (count($valor["children"]) > 0) {
                    
                    asort($valor["children"]);
                    // $this->json_novo_ordenado 
                    array_push($this->json_novo_ordenado, $valor["children"]);
                    $this->percorrer_json($valor["children"]);
        
                }
    
            }
            
        }

        return;

    }

    public function store(Request $request){

        $arvore = Arvore::create([
            'nome' => $request->nome,
            'json' => $request->json
        ]);

        return $arvore;
        
    }

    public function excluir_arvore($id){

        $arvore = Arvore::find($id);

        if ($arvore != null) {

            $arvore->delete();

        }
        
        $arvores = Arvore::get();

        return view('cms/listar_arvore', compact('arvores'));

    }

    public function editar_arvore($id){
        
        $arvore = Arvore::find($id);
        return view('cms/editar_arvore', compact('arvore'));
    }

    public function salvar_arvore_editada(Request $request){
        // dd($request);
        $arvore = Arvore::find($request->id);
        $arvore->nome = $request->nome;
        $arvore->json = $request->json;
        $arvore->save();
        
        $produto_arvore = ProdutoArvore::where('arvore_id', $request->id)->delete();

        return true;

    }

    public function get_json_produto(Request $request){

        $arvore = Arvore::find($request->id);
        $produto_arvore = ProdutoArvore::where('produto_id', $request->id_produto)->where('arvore_id', $request->id)->first();
        $array_retorno = [
            'arvore' => $arvore,
            'produto_arvore' => $produto_arvore
        ];
        return $array_retorno;

    }

    public function remover_arvore_atribuida(Request $request){

        $produto_arvore = ProdutoArvore::where('produto_id', $request->id_produto)->where('arvore_id', $request->id_arvore)->first();
        return $produto_arvore->delete();
    }

}
