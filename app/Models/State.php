<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['letters','name'];

    // Relacionamento com anestesias
    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state'); // Certifique-se de que "state_id" está na tabela `cities`
    }
}
