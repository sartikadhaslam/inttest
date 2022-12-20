<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemMaster;
use App\Models\PurchaseRequestApproval;
use App\Models\PurchaseRequestCategory;
use App\Models\PurchaseRequestDetail;
use App\Models\PurchaseRequestHeader;
use App\Models\PurchaseRequestAttach;
use App\Models\Unit;
use App\Models\MstEmployee;
use App\Models\ViewUserApv;
use App\Models\ItemPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use File;

class PurchaseRequestController extends Controller
{
    public function index(){
        $purchaseRequestHeader = PurchaseRequestHeader::select('Trx_Prq_Header.Prq_Code', 'Trx_Prq_Header.Prq_Date', 'Trx_Prq_Header.Prq_Req_CC',
                    'Trx_Prq_Header.Sts_Record', 'BOF_VW_DILD_Mst_Emp.Emp_Name')
            ->join('BOF_VW_DILD_Mst_Emp', 'BOF_VW_DILD_Mst_Emp.Emp_No', 'Trx_Prq_Header.Emp_No')
            ->orderBy('Trx_Prq_Header.Prq_Date', 'asc')
            ->paginate(15);

        $commonData = [
            'purchaseRequestHeader' => $purchaseRequestHeader
        ];

        return view('purchase-request.index', $commonData);
    }

    public function create(){
        $mstEmployee    = MstEmployee::orderBy('Emp_Name', 'asc')->get();
        $reqCC          = PurchaseRequestCategory::orderBy('Prq_Cat_Name', 'asc')->get();
        $goodsType      = ViewUserApv::select('BOF_VW_APV_UserApv.Prq_Cat', 'TB_Prq_Category.Prq_Cat_Name', 'BOF_VW_APV_UserApv.Cost_Center')
                            ->join('TB_Prq_Category', 'TB_Prq_Category.Cost_Center', 'BOF_VW_APV_UserApv.Cost_Center')
                            ->whereColumn('TB_Prq_Category.Prq_Cat', '=', 'BOF_VW_APV_UserApv.Prq_Cat')
                            ->where('BOF_VW_APV_UserApv.Criteria_Type', 'IT')
                            ->orderBy('TB_Prq_Category.Prq_Cat_Name')
                            ->distinct()
                            ->get();

        $commonData = [
            'mstEmployee'   => $mstEmployee,
            'reqCC'         => $reqCC,
            'goodsType'     => $goodsType
        ];

        return view('purchase-request.create', $commonData);
    }

    public function storeHeader(Request $request){
        $prCatGoodsType = PurchaseRequestCategory::where('Cost_Center', $request->Goods_Type)->first();
        $prCatReqCC = PurchaseRequestCategory::where('Cost_Center', $request->Cost_Center)->first();

        $storePurchaseRequestHeader = new PurchaseRequestHeader();
        $storePurchaseRequestHeader->Entity_Code        = $prCatGoodsType->Entity_Code;
        $storePurchaseRequestHeader->Profit_Center      = $prCatGoodsType->Profit_Center;
        $storePurchaseRequestHeader->Cost_Center        = $prCatGoodsType->Cost_Center;
        $storePurchaseRequestHeader->Prq_Code           = $request->Prq_Code;
        $storePurchaseRequestHeader->Class_CC           = $prCatGoodsType->Class_CC;
        $storePurchaseRequestHeader->Prq_Req_Entity     = $prCatReqCC->Entity_Code;
        $storePurchaseRequestHeader->Prq_Req_PC         = $prCatReqCC->Profit_Center;
        $storePurchaseRequestHeader->Prq_Req_CC         = $prCatReqCC->Cost_Center;
        $storePurchaseRequestHeader->Prq_Req_Class_CC   = $prCatReqCC->Class_CC;
        $storePurchaseRequestHeader->Emp_No             = $request->Emp_No;
        $storePurchaseRequestHeader->Emp_Email          = $request->Emp_Email;
        $storePurchaseRequestHeader->Prq_Date           = $request->Prq_Date;
        $storePurchaseRequestHeader->Prq_Date_Receive   = $request->Prq_Date;
        $storePurchaseRequestHeader->Prq_Desc           = $request->Prq_Desc;
        $storePurchaseRequestHeader->Cur_Code           = 'IDR';
        $storePurchaseRequestHeader->Prq_Total_Amnt     = 0;
        $storePurchaseRequestHeader->Prq_Cancel_Remarks = '';
        $storePurchaseRequestHeader->Prq_Doc_Ref_4SAP   = '';
        $storePurchaseRequestHeader->Prq_Cat            = $prCatGoodsType->Prq_Cat;
        $storePurchaseRequestHeader->Doc_Type           = 'PRQ';
        $storePurchaseRequestHeader->Prq_PIC            = $request->Requestor;
        $storePurchaseRequestHeader->Prq_Create_From    = 'DS';
        $storePurchaseRequestHeader->Prq_SAP_Status     = 'N';
        $storePurchaseRequestHeader->Prq_SAP_Doc        = '-';
        $storePurchaseRequestHeader->Prq_Soq_Ready      = 'N';
        $storePurchaseRequestHeader->Apv_Model          = 1;
        $storePurchaseRequestHeader->Apv_Type           = 2;
        $storePurchaseRequestHeader->Sts_Apv            = 'R';
        $storePurchaseRequestHeader->Sts_Record         = 'A';
        $storePurchaseRequestHeader->User_Entry         = 'gita.taruna';
        $storePurchaseRequestHeader->Date_Time_Entry    = $request->Prq_Date;
        $storePurchaseRequestHeader->User_Update        = 'gita.taruna';
        $storePurchaseRequestHeader->Date_Time_Update   = $request->Prq_Date;
        $storePurchaseRequestHeader->save();

        $viewUserApv = ViewUserApv::where([
                            ['Cost_Center', $prCatGoodsType->Cost_Center],
                            ['Doc_Type', 'PRQ'],
                            ['Criteria_Type', 'CC'],
                            ['Apv_Class_CC', $prCatGoodsType->Class_CC],
                            ['Sts_Record', 'A']
                        ])
                        ->orderBy('Apv_Seqn', 'asc')
                        ->orderBy('Apv_Version', 'asc')
                        ->get();

        foreach($viewUserApv as $viewUserApv){
            $storePurchaseRequestApproval = new PurchaseRequestApproval();
            $storePurchaseRequestApproval->Entity_Code      = $prCatGoodsType->Entity_Code;
            $storePurchaseRequestApproval->Profit_Center    = $prCatGoodsType->Profit_Center;
            $storePurchaseRequestApproval->Cost_Center      = $prCatGoodsType->Cost_Center;
            $storePurchaseRequestApproval->Apv_Class_CC     = $prCatGoodsType->Class_CC;
            $storePurchaseRequestApproval->Doc_Code         = $request->Prq_Code;
            $storePurchaseRequestApproval->Criteria_Type    = 'CC';
            $storePurchaseRequestApproval->Apv_Seqn         = $viewUserApv->Apv_Seqn;
            $storePurchaseRequestApproval->Apv_Order        = $viewUserApv->Apv_Order;
            $storePurchaseRequestApproval->Apv_Model        = $viewUserApv->Apv_Model;
            $storePurchaseRequestApproval->Apv_Version      = $viewUserApv->Apv_Version;
            $storePurchaseRequestApproval->Prq_Req_Entity   = $prCatReqCC->Entity_Code;
            $storePurchaseRequestApproval->Prq_Req_PC       = $prCatReqCC->Profit_Center;
            $storePurchaseRequestApproval->Prq_Req_CC       = $prCatReqCC->Cost_Center;
            $storePurchaseRequestApproval->Apv_Default      = $viewUserApv->Apv_Default;
            $storePurchaseRequestApproval->Apv_Title        = $viewUserApv->Apv_Title;
            $storePurchaseRequestApproval->Apv_User         = $viewUserApv->Apv_User;
            $storePurchaseRequestApproval->Apv_EmpNo        = $viewUserApv->Apv_EmpNo;
            $storePurchaseRequestApproval->Apv_Status       = '';
            $storePurchaseRequestApproval->Apv_Desc         = '';
            $storePurchaseRequestApproval->Apv_Approved     = '';
            $storePurchaseRequestApproval->Apv_Cancel_Doc   = 'N';
            $storePurchaseRequestApproval->Apv_Close_Doc    = 'N';
            $storePurchaseRequestApproval->Apv_Doc_Review   = 'N';
            $storePurchaseRequestApproval->Doc_Type         = 'PRQ';
            $storePurchaseRequestApproval->Apv_ByPass       = $viewUserApv->Apv_ByPass;
            $storePurchaseRequestApproval->Sts_Record       = 'X';
            $storePurchaseRequestApproval->User_Entry       = 'gita.taruna';
            $storePurchaseRequestApproval->Date_Time_Entry  = $request->Prq_Date;
            $storePurchaseRequestApproval->User_Update      = 'gita.taruna';
            $storePurchaseRequestApproval->Date_Time_Update = $request->Prq_Date;
            $storePurchaseRequestApproval->save();
        }

        return redirect('/purchase-request/edit/'. $request->Prq_Code)->with('success', 'Data Purchase Request Header berhasil disimpan!');
    }

    public function storeDetail(Request $request){
        $validator = Validator::make($request->all(),[
            'file' => 'required|mimes:jpeg,png,pdf,xlx,xlsx,docx,doc|max:10240',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if ($file = $request->file('file')) {
                $filename           = $request->file('file')->getClientOriginalName();
                $destinationPath    = 'uploads/';
                $profileFile        = date('YmdHis') . "_" . $filename;
                $extension          = $request->file('file')->extension();
                
                $file->move($destinationPath, $profileFile);
            }     

            $purchaseRequestHeader  = PurchaseRequestHeader::where('Prq_Code', $request->Prq_Code)->first();
            $purchaseRequestDetail  = PurchaseRequestDetail::where('Prq_Code', $request->Prq_Code)->get();
            $max                    = count($purchaseRequestDetail);
            $itemPrice              = ItemPrice::where([
                                                ['Item_ID', $request->Prq_Item_ID],
                                                ['Item_Prq_Category', $purchaseRequestHeader->Prq_Cat],
                                                ['Unit_Purch', $request->Prq_Item_Unit],
                                                ['Price_Trx_From', 'INV']
                                            ])
                                        ->orderBy('Date_Start', 'desc')
                                        ->first();
            if($itemPrice != null){
                $price = $itemPrice->Price_Purch;
            }else{
                $price = 0;
            }
            $storePurchaseRequestDetail = new PurchaseRequestDetail();
            $storePurchaseRequestDetail->Entity_Code            = $purchaseRequestHeader->Entity_Code;
            $storePurchaseRequestDetail->Profit_Center          = $purchaseRequestHeader->Profit_Center;
            $storePurchaseRequestDetail->Cost_Center            = $purchaseRequestHeader->Cost_Center;
            $storePurchaseRequestDetail->Prq_Code               = $purchaseRequestHeader->Prq_Code;
            $storePurchaseRequestDetail->Prq_Item_ID            = $request->Prq_Item_ID;
            $storePurchaseRequestDetail->Prq_Req_CC             = $purchaseRequestHeader->Prq_Req_CC;
            $storePurchaseRequestDetail->Item_Prq_Category      = $purchaseRequestHeader->Prq_Cat;
            $storePurchaseRequestDetail->Prq_Seqn_Detail        = $max+1;
            $storePurchaseRequestDetail->Prq_Item_Name          = $request->Prq_Item_Name;
            $storePurchaseRequestDetail->Prq_Item_Unit          = $request->Prq_Item_Unit;
            $storePurchaseRequestDetail->Prq_Item_Desc          = $request->Prq_Item_Desc;
            $storePurchaseRequestDetail->Prq_Item_Price         = $price;
            $storePurchaseRequestDetail->Prq_Qty                = $request->Prq_Qty;
            $storePurchaseRequestDetail->Prq_Amount             = $price*$request->Prq_Qty;
            $storePurchaseRequestDetail->Prq_Qty_Apv            = 0;
            $storePurchaseRequestDetail->Prq_Amount_Apv         = 0;
            $storePurchaseRequestDetail->Prq_FromStore_Residu   = 0;
            $storePurchaseRequestDetail->Prq_FromSOQ_Residu     = 0;
            $storePurchaseRequestDetail->Prq_Deduct_From        = 'PRQ';
            $storePurchaseRequestDetail->Prq_Flag_Qty           = 'F';
            $storePurchaseRequestDetail->Prq_Item_Section       = 'AS';
            $storePurchaseRequestDetail->Prq_Item_Class         = 'NI';
            $storePurchaseRequestDetail->Date_Requirement       = $request->Date_Requirement;
            $storePurchaseRequestDetail->Date_Realization       = $request->Date_Requirement;
            $storePurchaseRequestDetail->Item_Name_Ext          = '-';
            $storePurchaseRequestDetail->Item_ID_Ext            = '-';
            $storePurchaseRequestDetail->Item_Tracking_Number   = '';
            $storePurchaseRequestDetail->Sts_Record             = 'A';
            $storePurchaseRequestDetail->User_Entry             = 'gita.taruna';
            $storePurchaseRequestDetail->Date_Time_Entry        = date('Y-m-d');
            $storePurchaseRequestDetail->User_Update            = 'gita.taruna';
            $storePurchaseRequestDetail->Date_Time_Update       = date('Y-m-d');
            $storePurchaseRequestDetail->save();

            /*$storePurchaseRequestAttach = new PurchaseRequestAttach();
            $storePurchaseRequestAttach->Prq_Code           = $purchaseRequestHeader->Prq_Code;
            $storePurchaseRequestAttach->Prq_Item_ID        = $request->Prq_Item_ID;
            $storePurchaseRequestAttach->Attach_Code        = 1;
            $storePurchaseRequestAttach->Attach_Seqn        = 1;
            $storePurchaseRequestAttach->Entity_Code        = $purchaseRequestHeader->Entity_Code;
            $storePurchaseRequestAttach->Profit_Center      = $purchaseRequestHeader->Profit_Center;
            $storePurchaseRequestAttach->Cost_Center        = $purchaseRequestHeader->Cost_Center;
            $storePurchaseRequestAttach->Prq_Req_Entity     = $purchaseRequestHeader->Prq_Req_Entity;
            $storePurchaseRequestAttach->Prq_Req_PC         = $purchaseRequestHeader->Prq_Req_PC;
            $storePurchaseRequestAttach->Prq_Req_CC         = $purchaseRequestHeader->Prq_Req_CC;
            $storePurchaseRequestAttach->Attach_Doc_Type    = 'pdf';
            $storePurchaseRequestAttach->Apv_Seqn           = 1;
            $storePurchaseRequestAttach->Apv_Order          = 1;
            $storePurchaseRequestAttach->Apv_Model          = 1;
            $storePurchaseRequestAttach->Apv_Version        = 1;
            $storePurchaseRequestAttach->Apv_Class_CC       = 1;
            $storePurchaseRequestAttach->Apv_User           = '';
            $storePurchaseRequestAttach->File_Path          = 0;
            $storePurchaseRequestAttach->File_Name          = $profileFile;
            $storePurchaseRequestAttach->File_Ext           = $extension;
            $storePurchaseRequestAttach->save();*/

            return redirect('/purchase-request/edit/'. $request->Prq_Code)->with('message', 'Item berhasil ditambahkan!');            
        }
    }

    public function view(Request $request, $id){
        $mstEmployee            = MstEmployee::orderBy('Emp_Name', 'asc')->get();
        $reqCC                  = PurchaseRequestCategory::orderBy('Prq_Cat_Name', 'asc')->get();
        $purchaseRequestHeader  = PurchaseRequestHeader::where('Prq_Code', $id)->first();
        $purchaseRequestDetail  = PurchaseRequestDetail::where('Prq_Code', $id)->get();
        $itemMaster             = ItemMaster::where('Item_Prq_Category', $purchaseRequestHeader->Prq_Cat)->get();
        $goodsType              = ViewUserApv::select('BOF_VW_APV_UserApv.Prq_Cat', 'TB_Prq_Category.Prq_Cat_Name', 'BOF_VW_APV_UserApv.Cost_Center')
                                    ->join('TB_Prq_Category', 'TB_Prq_Category.Cost_Center', 'BOF_VW_APV_UserApv.Cost_Center')
                                    ->whereColumn('TB_Prq_Category.Prq_Cat', '=', 'BOF_VW_APV_UserApv.Prq_Cat')
                                    ->where('BOF_VW_APV_UserApv.Criteria_Type', 'IT')
                                    ->orderBy('TB_Prq_Category.Prq_Cat_Name')
                                    ->distinct()
                                    ->get();
        $purchaseRequestAppr    = PurchaseRequestApproval::where('Doc_Code', $id)->get();

        $commonData = [
            'itemMaster'            => $itemMaster,
            'purchaseRequestHeader' => $purchaseRequestHeader,
            'purchaseRequestDetail' => $purchaseRequestDetail,
            'reqCC'                 => $reqCC,
            'mstEmployee'           => $mstEmployee,
            'goodsType'             => $goodsType,
            'purchaseRequestAppr'   => $purchaseRequestAppr
        ];

        return view('purchase-request.view', $commonData);
    }

    public function edit(Request $request, $id){
        $mstEmployee            = MstEmployee::orderBy('Emp_Name', 'asc')->get();
        $reqCC                  = PurchaseRequestCategory::orderBy('Prq_Cat_Name', 'asc')->get();
        $purchaseRequestHeader  = PurchaseRequestHeader::where('Prq_Code', $id)->first();
        $purchaseRequestDetail  = PurchaseRequestDetail::where('Prq_Code', $id)->get();
        $itemMaster             = ItemMaster::where('Item_Prq_Category', $purchaseRequestHeader->Prq_Cat)->get();
        $goodsType              = ViewUserApv::select('BOF_VW_APV_UserApv.Prq_Cat', 'TB_Prq_Category.Prq_Cat_Name', 'BOF_VW_APV_UserApv.Cost_Center')
                                    ->join('TB_Prq_Category', 'TB_Prq_Category.Cost_Center', 'BOF_VW_APV_UserApv.Cost_Center')
                                    ->whereColumn('TB_Prq_Category.Prq_Cat', '=', 'BOF_VW_APV_UserApv.Prq_Cat')
                                    ->where('BOF_VW_APV_UserApv.Criteria_Type', 'IT')
                                    ->orderBy('TB_Prq_Category.Prq_Cat_Name')
                                    ->distinct()
                                    ->get();

        $commonData = [
            'itemMaster'            => $itemMaster,
            'purchaseRequestHeader' => $purchaseRequestHeader,
            'purchaseRequestDetail' => $purchaseRequestDetail,
            'reqCC'                 => $reqCC,
            'mstEmployee'           => $mstEmployee,
            'goodsType'             => $goodsType
        ];

        return view('purchase-request.edit', $commonData);
    }

    public function destroy($no, $id)
    {
        $delPurchaseRequestDetail = PurchaseRequestDetail::where('Prq_Code', $no)->where('Prq_Item_ID', $id)->delete();
        /*$delPurchaseRequestAttach = PurchaseRequestAttach::where('Prq_Code', $no)->where('Prq_Item_ID', $id)->delete();*/

        return redirect('/purchase-request/edit/'. $no)->with('message', 'Item berhasil dihapus!');
    }

    public function prCode(Request $request){
        $check   = PurchaseRequestHeader::where('Prq_Date', Carbon::today())->get();
        $max     = count($check);
        $prqCode = 'PRQ-'.$request->id.'-'.date('Ymd').'-'.sprintf("%04s", abs($max + 1));

        return response()->json($prqCode);
    }

    public function getItem(Request $request){
        $getItem   = ItemMaster::where('Item_ID', $request->id)->first();

        return response()->json($getItem);
    }
}
