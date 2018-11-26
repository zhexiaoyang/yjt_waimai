<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'takeout_goods';

    public function deopt()
    {
        return $this->belongsTo(Deopt::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
