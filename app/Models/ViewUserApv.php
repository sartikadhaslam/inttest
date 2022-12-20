<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewUserApv extends Model
{
    use HasFactory;

    protected $table = 'BOF_VW_APV_UserApv';

    protected $fillable = [
        'Prq_Cat',
        'Cost_Center',
        'Doc_Type',
        'Criteria_Type',
        'Apv_Seqn',
        'Apv_Order',
        'Apv_Model',
        'Apv_Version',
        'Apv_Class_CC',
        'Apv_Type',
        'Apv_Default',
        'Apv_Title',
        'Apv_EmpNo',
        'Apv_User',
        'Apv_ByPass',
        'Sts_Record',
        'User_Entry',
        'Date_Time_Entry',
        'User_Update',
        'Date_Time_Update',
    ];
}
