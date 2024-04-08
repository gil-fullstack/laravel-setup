<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncionalidadeProduto extends Model
{
    protected $table = 'site_funcionalidade_produto';

    protected $fillable = ['subfuncionalidade_id','produto_id'];

    public function subfuncionalidade(){
      return $this->belongsTo('App\Subfuncionalidade','subfuncionalidade_id');
    }
}
