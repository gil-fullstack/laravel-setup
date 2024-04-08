<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
  use SoftDeletes;

  protected $table = 'site_produtos';

  protected $fillable = ['titulo','descricao','texto','imagem','imagem_destaque','ordem','destaque','detalhes','categoria_produtos_id','link_download'];

  public function roles(){
    return $this->belongsToMany('App\Subfuncionalidade', 'site_funcionalidade_produto');
  }

  public function categoria(){
    return $this->belongsTo('App\CategoriaProduto','categoria_produtos_id');
  }

  public function precos(){
    return $this->hasMany('App\ProdutoModelo', 'produto_id');
  }

  public function arvores(){
  
    return $this->belongsToMany('App\Arvore', 'produtos_arvore');
  
  }
}
