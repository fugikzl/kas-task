<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePoint extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "storeId",
        "address",
        "lat",
        "lng"
    ];
}
