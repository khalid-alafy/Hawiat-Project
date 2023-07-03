<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Branch extends Model 
{
    use HasFactory,HasSpatial;

    protected $table = 'branches';
    public $timestamps = true;

    protected $fillable = [
        'name', 'location', 'company_id',
    ];

    protected $casts = [
                'location' => Point::class,
            ];
    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function departments():BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

}
