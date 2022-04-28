<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'user';

    protected $fillable = [
        'nome', 'data_nascimento', 'avatar_id'
    ];

    public function avatar(){
        return $this->hasOne(Avatar::class, 'id', 'avatar_id');
    }
}
