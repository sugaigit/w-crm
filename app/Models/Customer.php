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
        'branch',
        'branch_2',
        'department_2',
        'manager_name_2',
        'address_2',
        'phone_2',
        'email_2',
        'fax_2',
        'branch_3',
        'department_3',
        'manager_name_3',
        'address_3',
        'phone_3',
        'email_3',
        'fax_3',
        'branch_4',
        'department_4',
        'manager_name_4',
        'address_4',
        'phone_4',
        'email_4',
        'fax_4',
        'branch_5',
        'department_5',
        'manager_name_5',
        'address_5',
        'phone_5',
        'email_5',
        'fax_5',
        'branch_6',
        'department_6',
        'manager_name_6',
        'address_6',
        'phone_6',
        'email_6',
        'fax_6',
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
        $companySizePoint = empty($this->company_size) ? 1 : config('points.companySize')[intval($this->company_size)];
        $businessDevelopmentAreaPoint = empty($this->business_development_area) ? 1 : config('points.businessDevelopmentArea')[intval($this->business_development_area)];
        $businessExpansionPotentialPoint = empty($this->business_expansion_potential) ? 1 : config('points.businessExpansionPotential')[intval($this->business_expansion_potential)];
        $companyHistoryPoint = empty($this->company_history) ? 1 : config('points.companyHistory')[intval($this->company_history)];
        $reliabilityPoint = empty($this->reliability) ? 1 : config('points.reliability')[intval($this->reliability)];

        $customerRankPoint = $companySizePoint
            + $businessDevelopmentAreaPoint
            + $businessExpansionPotentialPoint
            + $companyHistoryPoint
            + $reliabilityPoint;

        return $customerRankPoint;
    }

    public function getCustomerRank()
    {
        $customerRankPoint = $this->getCustomerRankPoint();

        $customerRank = '';
        if ($customerRankPoint > 45) {
            $customerRank = 'SS';
        } elseif ($customerRankPoint > 40) {
            $customerRank = 'S';
        } elseif ($customerRankPoint > 34) {
            $customerRank = 'A';
        } elseif ($customerRankPoint > 24) {
            $customerRank = 'B';
        } elseif ($customerRankPoint > 10) {
            $customerRank = 'C';
        } else {
            $customerRank = 'D';
        }

        return $customerRank;
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
