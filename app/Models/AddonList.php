<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddonList extends Model
{

    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'addon_lists';

    protected $fillable = [
        'name',
        'billing_cycle',
        'price',
    ];
}
