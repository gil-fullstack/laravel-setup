<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionalidade extends Model
{
  use SoftDeletes;

  protected $table = 'site_funcionalidades';

  protected $fillable = ['descricao'];

  public function subfuncionalidades(){
    return $this->hasMany('App\Subfuncionalidade','funcionalidades_id');
  }
}
