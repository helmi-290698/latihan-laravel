<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function saledetail()
    {
        return $this->hasMany(Sale_detail::class);
    }
}
