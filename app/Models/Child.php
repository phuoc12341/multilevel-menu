<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Child extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'holy_name',
        'name',
        'group_id',
        'date_of_birth',
        'gender',
        'phone',
        'baptism',
        'holy_eucharist',
        'confirmation',
        'father',
        'mother',
        'address',
        'parish',
        'diocese',
    ];

    /**
     * Get the child's date of birth.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
}
