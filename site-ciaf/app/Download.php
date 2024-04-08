<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'downloads';
    public $timestamps = false;

    protected $primaryKey = 'download_id';


    protected $fillable = [
      'nome',
      'empresa',
      'email',
      'telefone',
      'modelo',
      'data',
      'onde',
      'ip',
      'contador_ip',
      'obs'
    ];
}
