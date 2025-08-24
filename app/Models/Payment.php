<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'tenant_name', 'amount', 'payment_date', 'status',];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
