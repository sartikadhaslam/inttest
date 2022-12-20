<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasFactory;

    protected $table = 'ST_Item_Price';

    protected $fillable = [
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Item_ID',
        'Item_Prq_Category',
        'Unit_Purch',
        'Unit_Sales',
        'Price_Purch',
        'Price_Sales',
        'Price_Period',
        'Date_Start',
        'Date_End',
        'Price_Trx_From',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];
}
