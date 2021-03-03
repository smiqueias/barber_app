<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'user_id'
    ];

    public function service() {
        return $this->hasMany(Service::class,'employee_id','id');
    }

    public function schedule() {
        return $this->hasOne(Schedule::class,'employee_id','id');
    }

    public function company() {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
