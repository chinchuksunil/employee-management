<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_id';

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'date_of_birth',
        'date_of_join',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_join' => 'date',
    ];

    public function getDateOfBirthFormatterAttribute()
    {
        return $this->date_of_birth?->format('d M Y');
    }

    public function getDateOfJoinFormatterAttribute()
    {
        return $this->date_of_join?->format('d M Y');
    }
}
