<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{

  protected $table = 'checkout';

  public $timestamps = false;

  protected $fillable = [   
    'id_modelo',
    'modelo',
    'nome',
    'cnpj_cpf',
    'razao',
    'fantasia',
    'email',
    'telefone',
    'celular',
    'momento',
    'licenciamento',
    'onde'
  ];
}
