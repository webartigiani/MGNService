<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'platform', 'version', 'manufacter', 'model', 'is_virtual', 'serial', 'uuid', 'is_online', 'enabled', 'status', 'status_date', 'latitude', 'longitude', 'accuracy', 'last_position', 'connection_type', 'app_version'
    ];
}
