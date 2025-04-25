@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Create Invoice
            </h5>
        </div>
        <div class="card-body">
            <Invoice-component id={{$id}}></Invoice-component>
        </div>
    </div>
</div>
@endsection
