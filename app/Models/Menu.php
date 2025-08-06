<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $primaryKey = 'menu_id';

    public function menuActions(){
        return $this->hasMany(Actionmenu::class,"menu_id");
    }
}
