<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

//    protected $guarded = ['id'];
    protected $fillable = [
        'building_no',
        'street_name',
        'city',
        'state',
        'country',
        'pincode',
        'user_id'
    ];

}
