<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codice_azienda', 'denominazione_azienda', 'cognome', 'nome', 'codice_fiscale', 'data_assunzione', 'data_cessazione', 'modo_timbratura', 'ore_settimanali', 'matricola', 'email', 'telefono'
    ];
}
