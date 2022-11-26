<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "name",
    ];


    public function isExists(int $id)
    {
        $store = Store::where("id",$id)->get()->first();

        if($store){
            return true;
        }else{
            return false;
        }
    }
}
