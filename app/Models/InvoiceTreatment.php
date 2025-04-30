<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTreatment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'treatMent',
        'subtype_id',
        'position_id'
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatMent', 'name');
    }

    public function subCategoryOne()
    {
        return $this->belongsTo(TreatmentSubCategoriesOne::class, 'subtype_id');
    }

    public function subCategoryTwo()
    {
        return $this->belongsTo(TreatmentSubCategoriesTwo::class, 'position_id');
    }
}
