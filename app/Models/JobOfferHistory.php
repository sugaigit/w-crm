<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferHistory extends Model
{

    use HasFactory;
    protected $table = 'job_offer_histories';
    protected $guarded = [];
    protected $fillable = [
        'job_offer_id',
        'user_id',
        'updated_content',
    ];

    protected $casts = [
        'updated_content'  => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobOffer()
    {
        return $this->belongsTo(jobOffer::class);
    }


}
