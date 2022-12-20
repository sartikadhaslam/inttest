<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstEmployee extends Model
{
    use HasFactory;

    protected $table = 'BOF_VW_DILD_Mst_Emp';

    protected $fillable = [
        'Emp_No',
        'Emp_Name',
        'Emp_ID',
        'Emp_Position_Code',
        'Emp_Position_Name',
        'Emp_Company_Code',
        'Emp_Company_Name',
        'Emp_Work_Location_Code',
        'Emp_Work_Location_Name',
        'Emp_Email',
    ];
}
