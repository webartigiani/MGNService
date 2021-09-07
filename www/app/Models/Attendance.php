<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'worker', 'entrance_date', 'entrance_ip', 'entrance_latitude', 'entrance_longitude', 'entrance_accuracy', 'exit_date', 'exit_ip', 'exit_latitude', 'exit_longitude', 'exit_accuracy', 'entrance_date_2', 'entrance_ip_2', 'entrance_latitude_2', 'entrance_longitude_2', 'entrance_accuracy_2', 'exit_date_2', 'exit_ip_2', 'exit_latitude_2', 'exit_longitude_2', 'exit_accuracy_2', 'check'
    ];
}
