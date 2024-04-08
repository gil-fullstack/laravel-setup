<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout2 extends Model
{

  protected $table = 'checkout2';

  public $timestamps = false;

  protected $fillable = [
    'id',
    'id_modelo',
    'modelo',
    'nome',
    'cnpj_cpf',
    'razao',
    'fantasia',
    'email',
    'telefone',
    'celular',
    'funcionarios',
    'faturamento',
    'momento',
    'licenciamento',
    'onde'
  ];
}
