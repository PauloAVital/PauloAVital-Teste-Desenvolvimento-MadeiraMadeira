<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlTag extends Model
{
    protected $table = 'control_tags';
    protected $fillable = ['id_user', 
                           'nome_github',
                           'language_github',
                           'link_github'
                          ];


    public function relUser() {
        return $this->hasOne('App\User', 'id', 'id_user' );
    }
} 
