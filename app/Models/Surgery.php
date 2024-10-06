<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surgery extends Model
{
    protected $fillable = [
        'user_id',
        'anestesista_id', 
        'cirurgiao_id', 
        'pediatra_id', 
        'enfermeiro_id',
        'date',
        'time',
        'name',
        'age',
        'state_id',
        'citie_id',
        'medical_record',
        'origin_department',
        'indication_id',
        'anesthesia',
        'surgery_id',
        'admission_date',
        'admission_time',
        'end_time',
        'apgar',
        'ligation',
        'social_status',
    ];
    protected $dates = ['date', 'admission_date'];

    // se necessário, você pode adicionar mutators
    public function getDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    // Relacionamento com o usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

     // Relação com Surgery_type
     public function surgery_type()
     {
         return $this->belongsTo(Surgery_type::class, 'surgery_id', 'id');
     }

    public function indication()
    {
        return $this->belongsTo(Indication::class);
    }

    // Relação com State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // Relação com City
    public function city()
    {
        return $this->belongsTo(City::class, 'citie_id');
    }

    // Relacionamento para professional
    public function professional()
    {
        return $this->belongsTo(Professional::class,'professional_id');
    }

    // Relacionamento para o Anestesista
    public function anestesista()
    {
        return $this->belongsTo(Professional::class, 'anestesista_id', 'id');
    }

    // Relacionamento para o Cirurgião
    public function cirurgiao()
    {
        return $this->belongsTo(Professional::class, 'cirurgiao_id', 'id');
    }

    // Relacionamento para o Pediatra
    public function pediatra()
    {
        return $this->belongsTo(Professional::class, 'pediatra_id', 'id');
    }
    // Relacionamento para o Pediatra
    public function enfermeiro()
    {
        return $this->belongsTo(Professional::class, 'enfermeiro_id');
    }

   

   
}
