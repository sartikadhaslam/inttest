<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'Trx_Prq_Detail';

    protected $fillable = [
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Prq_Code',
        'Prq_Item_ID',
        'Prq_Req_CC',
        'Item_Prq_Category',
        'Prq_Seqn_Detail',
        'Prq_Item_Name',
        'Prq_Item_Unit',
        'Prq_Item_Desc',
        'Prq_Item_Price',
        'Prq_Qty',
        'Prq_Amount',
        'Prq_Qty_Apv',
        'Prq_Amount_Apv',
        'Prq_FromStore_Residu',
        'Prq_FromSOQ_Residu',
        'Prq_Deduct_From',
        'Prq_Flag_Qty',
        'Prq_Item_Section',
        'Prq_Item_Class',
        'Date_Requirement',
        'Date_Realization',
        'Item_Name_Ext',
        'Item_ID_Ext',
        'Item_Tracking_Number',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];
}
