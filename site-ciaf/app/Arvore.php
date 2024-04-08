<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arvore extends Model
{
    protected $table = 'arvore_base';
    protected $primaryKey = 'id';

    protected $fillable = ['json', 'nome'];

    public function produtos(){
  
        return $this->belongsToMany('App\Produto', 'produtos_arvore');
      
    }
}
