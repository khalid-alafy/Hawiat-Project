<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Department extends Model 
{

    protected $table = 'departments';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'tenancy_type',
        'parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function branches():BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }

}