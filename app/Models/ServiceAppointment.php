<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceAppointment extends Model
{
    use HasFactory;
    protected $table = "service_appointments";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'user_id',
        'time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_id' => 'integer',
        'user_id' => 'integer',
        'time' => 'string',
    ];

    //
    //Relations
    //

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
