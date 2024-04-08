<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'site_categorias';

    protected $fillable = ['nome','descricao'];
}
