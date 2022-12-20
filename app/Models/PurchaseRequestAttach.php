<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestAttach extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'Trx_Prq_Attach';

    protected $fillable = [
        'Prq_Code',
        'Prq_Item_ID',
        'Attach_Code',
        'Attach_Seqn',
        'Entity_Code',
        'Profit_Center',
        'Cost_Center',
        'Prq_Req_Entity',
        'Prq_Req_PC',
        'Prq_Req_CC',
        'Attach_Doc_Type',
        'Apv_Seqn',
        'Apv_Order',
        'Apv_Model',
        'Apv_Version',
        'Apv_Class_CC',
        'Apv_User',
        'File_Path',
        'File_Name',
        'File_Ext',
    ];
}
