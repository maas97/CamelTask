<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionList extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'subscription_lists';

    protected $fillable = [
        'plan_name',
        'billing_cycle',
        'price',
    ];
}
