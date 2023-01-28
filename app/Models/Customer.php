<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // const KRAMER_FLAG_ON = 1;

    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'type',
        'handling_type',
        'handling_office',
        'corporate_type',
        'customer_name',
        'customer_kana',
        'address',
        'phone',
        'fax',
        'company_rank',
    ];


    public function user()
    {
        return $this->belongsTo(Company::class);
    }

    // public function customerLogs()
    // {
    //     return $this->hasMany(CustomerLog::class);
    // }

    public function jobOffer()
    {
        return $this->hasMany(JobOffer::class);
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
