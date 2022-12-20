<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;

    protected $table = 'ST_Item_Master';

    protected $fillable = [
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Item_ID',
        'Item_Barcode',
        'Item_Prq_Category',
        'Group_ID',
        'Item_Category',
        'Item_Name',
        'Item_Unit',
        'Item_Class',
        'Item_Section',
        'Item_Type',
        'Qty_Min',
        'Qty_Max',
        'Qty_Req_Max',
        'Qty_Min_Con',
        'Qty_Max_Con',
        'Qty_Req_Max_Con',
        'Input_SN',
        'Multiple_Qty',
        'Item_Price_Trx',
        'Item_Adj_Inv',
        'Item_Adj_Req',
        'Cancel_Remarks',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];

}
