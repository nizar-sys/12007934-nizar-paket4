<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'start_price',
        'item_desc',
        'item_image',
        'item_status',
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class, 'item_id', 'id');
    }
}
