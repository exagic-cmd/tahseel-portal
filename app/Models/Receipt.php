<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
     use HasFactory;
    protected $fillable = [
        'gate', 'trn', 'date', 'time', 'receipt_number', 'owner_name',
        'vehicle_number', 'total_amount', 'research_support', 'collection_fee', 
        'vat', 'user_name','entity','refno', 'appno'
    ];
}
