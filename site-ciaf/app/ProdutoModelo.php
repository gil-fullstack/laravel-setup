<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoModelo extends Model
{
    protected $table = 'site_produto_modelos';

    protected $fillable = ['nome','produto_id','preco','paypal','categoria_id','tag_2','tag_3','obs'];

    public function categoria(){
      return $this->belongsTo('App\Categoria','categoria_id');
    }
}
