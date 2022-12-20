<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestHeader extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'Trx_Prq_Header';

    protected $fillable = [
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Prq_Code',
        'Class_CC',
        'Prq_Req_Entity',
        'Prq_Req_PC',
        'Prq_Req_CC',
        'Prq_Req_Class_CC',
        'Emp_No',
        'Emp_Email',
        'Prq_Date',
        'Prq_Date_Receive',
        'Prq_Desc',
        'Cur_Code',
        'Prq_Total_Amnt',
        'Prq_Cancel_Remarks',
        'Prq_Doc_Ref_4SAP',
        'Prq_Cat',
        'Doc_Type',
        'Prq_PIC',
        'Prq_Create_From',
        'Prq_SAP_Status',
        'Prq_SAP_Doc',
        'Prq_Soq_Ready',
        'Apv_Model',
        'Apv_Type',
        'Sts_Apv',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];
}
