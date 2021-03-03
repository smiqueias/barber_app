<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'cost',
        'employee_id'
    ];

    public function schedule() {
        return $this->hasOne(Schedule::class,'service_id');
    }
}
