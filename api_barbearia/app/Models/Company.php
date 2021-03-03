<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'phone',
        'social_link'
    ];


    public function employees() {
        return $this->hasMany(Employee::class,'company_id','id');
    }

}
