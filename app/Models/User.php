<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml( name="User" ),
 *     required={"name","email","password","phone","image","location","role","suspend"},
 *     @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="User@gmail.com"),
 *     @OA\Property(property="name", type="string", readOnly="true", example="User"),
 *     @OA\Property(property="password", type="string", readOnly="true", format="password",example="password12345"),
 *     @OA\Property(property="phone", type="string", readOnly="true",description="User unique mobile number", example="055 123 4567"),
 *     @OA\Property(property="image", type="string", readOnly="true",description="user photo", example="avatar.png"),
 *     @OA\Property(property="location", type="string", readOnly="true", example="'40.7128','-74.0060'"),
 *     @OA\Property(property="role", type="enum", readOnly="true", example="user"),
 *     @OA\Property(property="suspend", type="boolean", readOnly="true", example="0"),
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSpatial;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'image', 'location', 'role', 'suspend',
    ];

    protected $hidden = [
        "created_at", "updated_at", 'password', 'remember_token',
    ];
    protected $casts = [
//            'email_verified_at' => 'datetime',
//            'password' => 'hashed',
        'location' => Point::class,
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


}
