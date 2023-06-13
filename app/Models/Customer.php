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
        'user_id',
        'handling_type',
        'handling_office',
        'corporate_type',
        'customer_name',
        'customer_kana',
        'industry',
        'company_size',
        'business_development_area',
        'business_expansion_potential',
        'company_history',
        'reliability',
        'address',
        'phone',
        'fax',
        'company_rank',
    ];


    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // public function customerLogs()
    // {
    //     return $this->hasMany(CustomerLog::class);
    // }

    public function jobOffer()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function getCustomerRankPoint()
    {
        $companySizePoint = empty($this->company_size) ? 0 : config('points.companySize')[intval($this->company_size)];
        $businessDevelopmentAreaPoint = empty($this->business_development_area) ? 0 : config('points.businessDevelopmentArea')[intval($this->business_development_area)];
        $businessExpansionPotentialPoint = empty($this->business_expansion_potential) ? 0 : config('points.businessExpansionPotential')[intval($this->business_expansion_potential)];
        $companyHistoryPoint = empty($this->company_history) ? 0 : config('points.companyHistory')[intval($this->company_history)];
        $reliabilityPoint = empty($this->reliability) ? 0 : config('points.reliability')[intval($this->reliability)];

        $customerRankPoint = $companySizePoint
            + $businessDevelopmentAreaPoint
            + $businessExpansionPotentialPoint
            + $companyHistoryPoint
            + $reliabilityPoint;

        return $customerRankPoint;
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
