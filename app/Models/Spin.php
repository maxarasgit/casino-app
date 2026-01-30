<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    protected $fillable = ['user_id', 'result', 'bet', 'payout'];
}