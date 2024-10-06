<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surgery_type extends Model
{
    protected $fillable = ['id','descricao',];
    
    public function surgery(): HasMany
    {
        return $this->hasMany(Surgery::class, 'surgery_id');
    }
}
