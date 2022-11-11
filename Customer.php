<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // const KRAMER_FLAG_ON = 1;

    use HasFactory;
    protected $guarded = [];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customerLogs()
    {
        return $this->hasMany(CustomerLog::class);
    }

}
