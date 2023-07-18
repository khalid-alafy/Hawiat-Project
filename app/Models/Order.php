<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Order extends Model 
{ 
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = [
        'quantity', 'total_price', 'currency', 'tenancy', 'user_id', 'product_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

}