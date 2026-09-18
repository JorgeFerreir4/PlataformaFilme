<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    // append hashid 
    
    protected $fillable = [
        'titulo', 
        'diretor', 
        'ano', 
        'genero', 
        'sinopse',
        'capa'];
}
