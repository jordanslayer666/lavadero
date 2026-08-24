<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wash extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'washer_id',
        'vehicle_type',
        'plate_number',
        'color',
        'details',
        'photo_path',
        'price',
        'payment_method',
        'washer_payment',
        'status',
    ];

    public function washer()
    {
        return $this->belongsTo(User::class, 'washer_id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
