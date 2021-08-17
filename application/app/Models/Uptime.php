<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uptime extends Model
{
    use HasFactory;

    protected $dates = ['morningFrom', 'morningTo', 'afternoonFrom', 'afternoonTo', 'eveningFrom', 'eveningTo'];
}
