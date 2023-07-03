<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'image',
        'contract_price',
        'temporary_price',
        'volume',
        'description',
        'tenancy_type',
        'branch_id',
        'department_id',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

}