<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model 
{

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = [
        'body',
        'user_id',
        'company_id',
    ];
    public function user():Belongsto
    {
        return $this->belongsTo(user::class);
    }

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}