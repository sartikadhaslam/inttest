<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestApproval extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'Trx_Prq_Apv';

    protected $fillable = [
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Apv_Class_CC',
        'Doc_Code',
        'Criteria_Type',
        'Apv_Seqn',
        'Apv_Order',
        'Apv_Model',
        'Apv_Version',
        'Prq_Req_Entity',
        'Prq_Req_PC',
        'Prq_Req_CC',
        'Apv_Default',
        'Apv_Title',
        'Apv_User',
        'Apv_EmpNo',
        'Apv_Status',
        'Apv_Desc',
        'Apv_Approved',
        'Apv_Cancel_Doc',
        'Apv_Close_Doc',
        'Apv_Doc_Review',
        'Doc_Type',
        'Apv_ByPass',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];
}
