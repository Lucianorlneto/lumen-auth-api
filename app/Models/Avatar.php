<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'avatar';

    protected $fillable = [
        'original_nome', 'nome', 'path'
    ];
}
