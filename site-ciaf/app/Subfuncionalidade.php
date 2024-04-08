<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subfuncionalidade extends Model
{

  use SoftDeletes;
  protected $table = 'site_subfuncionalidades';
  protected $fillable = ['titulo','funcionalidades_id'];

  public function funcionalidade(){
    return $this->belongsTo('App\Funcionalidade','funcionalidades_id');
  }
}
