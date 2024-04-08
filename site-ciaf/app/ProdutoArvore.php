<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoArvore extends Model
{
    protected $table = "produtos_arvore";
    protected $fillable = [
        'produto_id',
        'arvore_id',
        'funcionalidades_selecionadas',
    ]; 
}
