<?php

namespace Arghavan\CaseCost\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CaseCostSettings extends Model
{
    protected $table = 'case_cost_settings';
    protected $fillable = ['name', 'label', 'percentage'];

    
}

