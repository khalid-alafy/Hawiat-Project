<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model 
{
    use HasFactory;

    protected $table = 'branches';
    public $timestamps = true;

    public function company()
    {
        return $this->belongsTo('Company');
    }

    public function products()
    {
        return $this->hasMany('Product');
    }

    public function departments()
    {
        return $this->belongsToMany('Deparment');
    }

}