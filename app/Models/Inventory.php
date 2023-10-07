<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function saledetail()
    {
        return $this->hasMany(Sale_detail::class);
    }
    public function purchasedetail()
    {
        return $this->hasMany(Purchase_detail::class);
    }
}
