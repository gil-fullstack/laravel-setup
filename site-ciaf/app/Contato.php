<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'site_contatos';
    protected $fillable = [
      'nome',
      'telefone',
      'email',
      'assunto',
      'mensagem',
      'ip',
      'onde'
    ];
}
