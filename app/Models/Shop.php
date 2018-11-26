<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'takeout_shops';

    public function detail()
    {
        return $this->hasOne(ShopDetail::class)->withDefault([
            'coefficient' => 15,
        ]);
    }
}
