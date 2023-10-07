<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_detail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
