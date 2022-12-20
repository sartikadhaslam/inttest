@extends('layouts.app')

@section('content')

    <div class="container">
      <div class="py-5 text-center">
        <h2>View Purchase Request</h2>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Header</h4>
          <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Date</label>
                  <input type="date" class="form-control" id="Prq_Date" name="Prq_Date" value="{{ date('Y-m-d', strtotime($purchaseRequestHeader->Prq_Date)) }}" readonly>
                </div>
                <div class="mb-3">
                  <label for="country">Req.CC</label>
                  <select class="custom-select d-block w-100" id="Cost_Center" name="Cost_Center" disabled>
                    <option value="">Choose...</option>
                    @foreach($reqCC as $reqCC)
                    <option value="{{ $reqCC->Cost_Center }}" <?php if($reqCC->Cost_Center == $purchaseRequestHeader->Prq_Req_CC){echo 'selected';} ?>>{{ $reqCC->Prq_Cat_Name }} ({{ $reqCC->Cost_Center}})</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label>Requestor</label>
                  <select class="custom-select d-block w-100" id="Requestor" name="Requestor" disabled>
                    <option value="">Choose...</option>
                    @foreach($mstEmployee as $mstEmployee)
                    <option value="{{ $mstEmployee->Emp_No }}" <?php if($mstEmployee->Emp_No == $purchaseRequestHeader->Prq_PIC){echo 'selected';} ?>>{{ $mstEmployee->Emp_Name }} ({{ $mstEmployee->Emp_No }})</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label>Goods Type</label>
                  <select class="custom-select d-block w-100" id="Goods_Type" name="Goods_Type" disabled>
                    <option value="">Choose...</option>
                    @foreach($goodsType as $goodsType)
                    <option value="{{ $goodsType->Cost_Center }}" <?php if($goodsType->Cost_Center == $purchaseRequestHeader->Cost_Center){echo 'selected';} ?>>{{ $goodsType->Prq_Cat_Name }} ({{ $goodsType->Prq_Cat }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Prq.Code</label>
                  <input type="text" class="form-control" id="Prq_Code" name="Prq_Code" value="{{ $purchaseRequestHeader->Prq_Code}}" readonly>
                </div>
                <div class="mb-3">
                  <label>Employee</label>
                  <input type="text" class="form-control" value="Gita Taruna (0001775)" readonly>
                  <input type="hidden" class="form-control" id="Emp_No" name="Emp_No" value="{{ $purchaseRequestHeader->Emp_No }}">
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="text" class="form-control" id="Emp_Email" name="Emp_Email" value="{{ $purchaseRequestHeader->Emp_Email }}" readonly>
                </div>
                <div class="mb-3">
                  <label>Status Record</label>
                  <input type="text" class="form-control" id="Sts_Record" name="Sts_Record" value="PRQ Creating" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea class="form-control" id="Prq_Desc" name="Prq_Desc" readonly>{{ $purchaseRequestHeader->Prq_Desc }}</textarea>
              </div>
            </div>

          <hr class="mb-4">

          <h4 class="mb-3">Detail</h4>
          <div class="table-responsive pt-3">
            <table class="table table-striped table-sm">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Quantity</th>
                      <th>Unit</th>
                      <th>Delivery Date</th>
                      <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($purchaseRequestDetail as $purchaseRequestDetail)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $purchaseRequestDetail->Prq_Item_ID }}</td>
                      <td>{{ $purchaseRequestDetail->Prq_Item_Name }}</td>
                      <td>{{ $purchaseRequestDetail->Prq_Qty }}</td>
                      <td>{{ $purchaseRequestDetail->Prq_Item_Unit }}</td>
                      <td>{{ $purchaseRequestDetail->Date_Requirement }}</td>
                      <td>{{ $purchaseRequestDetail->Prq_Item_Desc }}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
     
          <hr class="mb-4">
          <h4 class="mb-3">Approval</h4>
          <div class="table-responsive pt-3">
            <table class="table table-striped table-sm">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>User</th>
                      <th>Role</th>
                      <th>Role Desc</th>
                      <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($purchaseRequestAppr as $purchaseRequestAppr)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $purchaseRequestAppr->Apv_User }}</td>
                      <td>{{ $purchaseRequestAppr->Apv_Title }}</td>
                      <td>{{ $purchaseRequestAppr->Prq_Qty }}</td>
                      <td>{{ $purchaseRequestAppr->Apv_Status }}</td>
                      <td></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
      </div>
    </div>
@endsection