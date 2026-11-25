<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeDetail extends Model
{
    protected $fillable = [
        'fee_id',
        'enrollment_id',
        'amount',
        'fee_category_id'
    ];

    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }

    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

}
