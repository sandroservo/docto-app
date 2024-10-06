<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $fillable = ['name','specialty', 'status'];

    public function surgery()
    {
        return $this->hasMany(Surgery::class, 'professional_id');
    }
}
