<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'handling_type',
        'job_number',
        'handling_office',
        'business_type',
        'customer_id',
        'type_contract',
        'new_reorder',
        'recruitment_number',
        'company_name',
        'company_address',
        'company_others',
        'ordering_business',
        'order_details',
        'counter_measures',
        'invoice_unit_price_1',
        'billing_unit_1',
        'profit_rate_1',
        'billing_information_1',
        'invoice_unit_price_2',
        'billing_unit_2',
        'profit_rate_2',
        'billing_information_2',
        'invoice_unit_price_3',
        'billing_unit_3',
        'profit_rate_3',
        'billing_information_3',
        'employment_insurance',
        'social_insurance',
        'payment_unit_price_1',
        'payment_unit_1',
        'carfare_1',
        'carfare_payment_1',
        'carfare_payment_remarks_1',
        'employment_insurance_2',
        'social_insurance_2',
        'payment_unit_price_2',
        'payment_unit_2',
        'carfare_2',
        'carfare_payment_2',
        'carfare_payment_remarks_2',
        'employment_insurance_3',
        'social_insurance_3',
        'payment_unit_price_3',
        'payment_unit_3',
        'carfare_3',
        'carfare_payment_3',
        'carfare_payment_remarks_3',
        'scheduled_period',
        'expected_end_date',
        'period_remarks',
        'holiday',
        'long_vacation',
        'holiday_remarks',
        'working_hours_1',
        'actual_working_hours_1',
        'break_time_1',
        'overtime',
        'working_hours_remarks',
        'working_hours_2',
        'actual_working_hours_2',
        'break_time_2',
        'working_hours_3',
        'actual_working_hours_3',
        'break_time_3',
        'nearest_station',
        'travel_time_station',
        'nearest_bus_stop',
        'travel_time_bus_stop',
        'commuting_by_car',
        'traffic_commuting_remarks',
        'parking',
        'posting_site',
        'status',
        'job_withdrawal',
        'order_date',
        'qualification',
        'qualification_content',
        'experience',
        'experience_content',
        'sex',
        'age',
        'uniform_supply',
        'supply',
        'clothes',
        'other_hair_colors',
        'self_prepared',
        'remarks_workplace',
        'gender_ratio',
        'age_ratio',
        'after_introduction',
        'timing_of_switching',
        'monthly_lower_limit',
        'monthly_upper_limit',
        'annual_lower_limit',
        'annual_upper_limit',
        'bonuses_treatment',
        'holidays_vacations',
        'introduction_others',
        'number_of_ordering_bases',
        'order_number',
        'transaction_duration',
        'expected_sales',
        'profit_rate',
        'special_matters'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityRecords()
    {
        return $this->hasMany(ActivityRecord::class);
    }

    public function getJobOfferPoint()
    {
        $numberOfOrderingBasesPoint = empty($this->number_of_ordering_bases) ? 0 : config('points.numberOfOrderingBases')[intval($this->number_of_ordering_bases)];
        $orderNumberPoint = empty($this->order_number) ? 0 : config('points.orderNumber')[intval($this->order_number)];
        $transactionDurationPoint = empty($this->transaction_duration) ? 0 : config('points.transactionDuration')[intval($this->transaction_duration)];
        $expectedSalesPoint = empty($this->expected_sales) ? 0 : config('points.expectedSales')[intval($this->expected_sales)];
        $profitRatePoint = empty($this->profit_rate) ? 0 : config('points.profitRate')[intval($this->profit_rate)];
        $specialMattersPoint = empty($this->special_matters) ? 0 : config('points.specialMatters')[intval($this->special_matters)];

        $JobOfferPoint = $numberOfOrderingBasesPoint
            + $orderNumberPoint
            + $transactionDurationPoint
            + $expectedSalesPoint
            + $profitRatePoint
            + $specialMattersPoint;

        return $JobOfferPoint;
    }

    // public function customerLogs()
    // {
    //     return $this->hasMany(CustomerLog::class);
    // }

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
