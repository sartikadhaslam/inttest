@extends('layouts.app')

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Request</h1>
    </div>
    <a href="{{route('purchase-request.create')}}" class="btn btn-sm btn-primary">+ Add</a>
    <div class="table-responsive pt-3">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Prq.Code</th>
            <th>Date</th>
            <th>Req CC</th>
            <th>Employee</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchaseRequestHeader as $purchaseRequestHeaders)
        <tr>
            <td>{{ $purchaseRequestHeaders->Prq_Code }}</td>
            <td>{{ $purchaseRequestHeaders->Prq_Date }}</td>
            <td>{{ $purchaseRequestHeaders->Prq_Req_CC }}</td>
            <td>{{ $purchaseRequestHeaders->Emp_Name }}</td>
            <td>
                <a class="btn btn-sm btn-primary text-white" href="{{ url('/purchase-request/view/'. $purchaseRequestHeaders->Prq_Code) }}">View</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $purchaseRequestHeader->links() }}
    </div>
</main>
@endsection
