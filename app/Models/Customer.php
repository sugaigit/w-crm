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

    // public function updateCustomer($request,$cutomer)
    // {
    //     $result = $cutomer->fill([client_name => $request->client_name])->save();

    //     return $result;
    // }
    // public function isKramer(): bool
    // {
    //     return $this->kramer_flag == Customer::KRAMER_FLAG_ON;
    // }
}
