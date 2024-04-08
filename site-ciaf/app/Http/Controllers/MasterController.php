<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\CategoriaProduto;
use App\Conteudo;

class MasterController extends Controller
{
    public static function footer(){
      $produtos = CategoriaProduto::where('destaque',1)->orderBy('ordem')->get();
      $redes_sociais = Conteudo::where('pagina_id',4)->orderBy('ordem')->get();
      $links_uteis = Conteudo::where('pagina_id',5)->where('destaque',1)->orderBy('ordem')->get();
      $tag_facebook = Conteudo::where('pagina_id',6)->first();

      return compact('produtos','redes_sociais','links_uteis','tag_facebook');
    }

    public static function navbar(){
      $telefones = Conteudo::where('pagina_id',7)->orderBy('ordem')->get();
      $produtos = CategoriaProduto::where('destaque',1)->orderBy('ordem')->get();
      $logo = Conteudo::where('pagina_id',17)->first();

      return compact('telefones','produtos','logo');
    }
}
