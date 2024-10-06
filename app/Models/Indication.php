<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indication extends Model
{
    protected $fillable = ['descricao',];

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class); // Nome do modelo deve ser em camel case
    }
}
