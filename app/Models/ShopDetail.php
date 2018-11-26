<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDetail extends Model
{
    protected $table = 'takeout_shop_details';

    protected $fillable = ["shop_id","opening_bank","username","account_number","is_invoice","type","name","number","coefficient"];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
