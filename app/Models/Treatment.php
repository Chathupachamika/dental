<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'showDropDown',
    ];

    public function subCategories()
    {
        return $this->hasMany(TreatmentSubCategoriesOne::class);
    }
}
