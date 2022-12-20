@extends('layouts.app')

@section('content')

    <div class="container">
      <div class="py-5 text-center">
        <h2>Add Purchase Request</h2>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Header</h4>
          <form class="needs-validation" action="{{ route('purchase-request.store') }}" method="POST">
          @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Date</label>
                  <input type="date" class="form-control" id="Prq_Date" name="Prq_Date" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="mb-3">
                  <label for="country">Req.CC</label>
                  <select class="custom-select d-block w-100" id="Cost_Center" name="Cost_Center" required>
                    <option value="">Choose...</option>
                    @foreach($reqCC as $reqCC)
                    <option value="{{ $reqCC->Cost_Center }}">{{ $reqCC->Prq_Cat_Name }} ({{ $reqCC->Cost_Center}})</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label>Requestor</label>
                  <select class="custom-select d-block w-100" id="Requestor" name="Requestor" required>
                    <option value="">Choose...</option>
                    @foreach($mstEmployee as $mstEmployee)
                    <option value="{{ $mstEmployee->Emp_No }}">{{ $mstEmployee->Emp_Name }} ({{ $mstEmployee->Emp_No }})</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label>Goods Type</label>
                  <select class="custom-select d-block w-100" id="Goods_Type" name="Goods_Type" required>
                    <option value="">Choose...</option>
                    @foreach($goodsType as $goodsType)
                    <option value="{{ $goodsType->Cost_Center }}">{{ $goodsType->Prq_Cat_Name }} ({{ $goodsType->Prq_Cat }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Prq.Code</label>
                  <input type="text" class="form-control" id="Prq_Code" name="Prq_Code" readonly>
                </div>
                <div class="mb-3">
                  <label>Employee</label>
                  <input type="text" class="form-control" value="Gita Taruna (0001775)" readonly>
                  <input type="hidden" class="form-control" id="Emp_No" name="Emp_No" value="0001775">
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="text" class="form-control" id="Emp_Email" name="Emp_Email" value="gita.taruna@intiland.com" readonly>
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
                <textarea class="form-control" id="Prq_Desc" name="Prq_Desc" required></textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-success">Save Header</button>
          </form>
      </div>
    </div>
@endsection

@push('script')
<script type="text/javascript">
     $(document).ready(function () {
        $("#Cost_Center").change(function () {
            var id= $(this).val();
            $.ajax({
                method:"get",
                url: "{{ route('get-pr-code') }}",
                data: {"_token": "{{ csrf_token() }}", "id":id},
                dataType: 'json', 
                success:function (data) {
                     $('#Prq_Code').val(data);
                },
                error:function () {

                }
            })

        });
    });
</script>
@endpush

