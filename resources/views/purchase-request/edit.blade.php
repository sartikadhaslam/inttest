@extends('layouts.app')

@section('content')

    <div class="container">
      <div class="py-5 text-center">
        <h2>Add Purchase Request</h2>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Header</h4>
          @if (session()->has('success'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {{ session('success') }}
              </div>
          @endif
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
          <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addItem">+ Add Item</a>
          @if (session()->has('message'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {{ session('message') }}
              </div>
          @endif
          <div class="modal" id="addItem">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Item</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <form action="{{ url('/purchase-request/store/'.$purchaseRequestHeader->Prq_Code) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label>Item ID</label>
                          <input type="hidden" id="Prq_Code" name="Prq_Code" value="{{ $purchaseRequestHeader->Prq_Code}}">
                          <select class="custom-select d-block w-100" id="Prq_Item_ID" name="Prq_Item_ID" required>
                            <option value="">Choose...</option>
                            @foreach($itemMaster as $itemMaster)
                            <option value="{{ $itemMaster->Item_ID }}">{{ $itemMaster->Item_ID }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label>Item Name</label>
                          <input type="text" class="form-control" id="Prq_Item_Name" name="Prq_Item_Name" readonly>
                        </div>
                        <div class="mb-3">
                          <label>Spesification</label>
                          <textarea class="form-control" id="Prq_Item_Desc" name="Prq_Item_Desc" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="Prq_Qty" name="Prq_Qty" required>              
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Unit</label>
                            <input type="text" class="form-control" id="Prq_Item_Unit" name="Prq_Item_Unit" readonly>        
                          </div>  
                        </div>
                        <div class="mb-3">
                          <label>Delivery Date</label>
                          <input type="date" class="form-control" id="Date_Requirement" name="Date_Requirement" required>
                        </div>
                        <div class="mb-3">
                          <label>Attachment</label>
                          <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Save Item</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
                </form>
              </div>
            </div>
          </div>

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
                      <th>Action</th>
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
                      <td>
                        <form method="POST" action="{{ url('/purchase-request/destroy/item/'.$purchaseRequestDetail->Prq_Code.'/'.$purchaseRequestDetail->Prq_Item_ID) }}" onsubmit="return validateForm()">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-sm btn-danger" value="Hapus">
                        </form>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
      </div>
    </div>
@endsection

@push('script')
<script type="text/javascript">
     $(document).ready(function () {
        $("#Prq_Item_ID").change(function () {
            var id= $(this).val();
            $.ajax({
                method:"get",
                url: "{{ route('get-item') }}",
                data: {"_token": "{{ csrf_token() }}", "id":id},
                dataType: 'json', 
                success:function (data) {
                     $('#Prq_Item_Name').val(data.Item_Name);
                     $('#Prq_Item_Unit').val(data.Item_Unit);
                },
                error:function () {

                }
            })

        });
    });

    function validateForm(){
        if (confirm("Yakin data akan dihapus?") == true) {
        return true;
        } else {
        return false;
        }
    }
</script>
@endpush