<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_detail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
