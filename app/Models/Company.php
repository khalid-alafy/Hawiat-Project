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
use Illuminate\Database\Eloquent\Relations\HasMany;


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

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function rates():HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

}