<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'site_configuracoes';
    protected $fillable = ['valor'];
}
