<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeAchat extends Model
{
  protected $primaryKey='modeAchat_id';

  protected $fillable= [
    'modeAchat_id',
    'libelleModeAchat'
  ];
}
