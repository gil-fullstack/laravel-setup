<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaProduto extends Model
{
  use SoftDeletes;

  protected $table = 'site_categoria_produtos';

  protected $fillable = ['titulo','imagem_destaque','ordem','destaque'];
}
