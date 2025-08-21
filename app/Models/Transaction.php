<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_app_id',
        'user_id',
        'label',
        'amount',
        'period',
        'account_id',
        'paid',
        'category_id',
        'type'
    ];
    //
}
