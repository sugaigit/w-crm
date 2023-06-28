<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityRecord extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'date',
        'item',
        'detail',
        'job_offer_id',
    ];


    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }
}
