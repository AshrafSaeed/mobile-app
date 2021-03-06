<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $guarded = [];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
