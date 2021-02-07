<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id', 'ud_id', 'app_id', 'language', 'os_name'
    ];

    /**
     * Get the user that owns the device.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
