<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentSubCategoriesOne extends Model
{
    protected $fillable = [
        'treatment_id',
        'name',
        'description',
        'showDropDown'
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
