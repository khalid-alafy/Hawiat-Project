<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
// use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;


class Company extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable,HasSpatial;

    protected $guard = 'company';
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'owner_name',
        'email',
        'commercial_register',
        'phone',
        'password',
        'tax_record',
        'city',
        'location',
    ];

    protected $casts = [
        'location' => Point::class,
    ];

    public $timestamps = true;

    public function branches()
    {
        return $this->hasMany('Branch');
    }

    public function complaints()
    {
        return $this->hasMany('Complaint');
    }

    public function rates()
    {
        return $this->hasMany('Rate');
    }

    public function reviews()
    {
        return $this->hasMany('Review');
    }

}