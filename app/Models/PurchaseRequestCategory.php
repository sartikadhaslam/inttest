<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestCategory extends Model
{
    use HasFactory;
    
    protected $table = 'TB_Prq_Category';

    protected $fillable = [
        'Prq_Cat',
        'Prq_Cat_Name',
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Class_CC',
        'Prq_Cat_Type',
        'Prq_Cat_Stock',
        'Prq_Hierarchy_Area',
        'Sts_Record',
    ];


}
