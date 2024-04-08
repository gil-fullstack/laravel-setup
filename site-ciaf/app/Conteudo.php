<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conteudo extends Model
{
  use SoftDeletes;

  protected $table = 'site_conteudos';

  protected $fillable = ['titulo','descricao','texto','imagem','destaque','pagina_id','ordem','imagem_responsiva','link','arquivo'];

}
