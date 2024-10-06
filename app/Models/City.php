<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name','state'];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'citie_id');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class,'id' );
    }
}
