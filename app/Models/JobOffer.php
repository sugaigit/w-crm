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
        'company_type',
        'job_number',
        'handling_office',
        'business_type',
        'corporate_type',
        'customer_id',
        'type_contract',
        'new_reorder',
        'recruitment_number',
        'company_name',
        'company_address',
        'company_others',
        'ordering_business',
        'order_details',
        'measures_existence',
        'counter_measures',
        'Invoice_unit_price_1',
        'billing_unit_1',
        'profit_rate_1',
        'billing_information_1',
        'Invoice_unit_price_2',
        'billing_unit_2',
        'profit_rate_2',
        'billing_information_2',
        'Invoice_unit_price_3',
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
        'payment_unit_price_2',
        'payment_unit_2',
        'carfare_2',
        'carfare_payment_2',
        'carfare_payment_remarks_2',
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
        'order_date',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
