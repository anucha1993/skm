@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Customer Details</h4>
            <div>
                @canany(['edit-customer'])
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcanany
                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Customer Name:</label>
                        <p class="form-control-plaintext">{{ $customer->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Country:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-info">{{ $customer->country }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Status:</label>
                        <p class="form-control-plaintext">
                            @if($customer->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Disabled</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Created Date:</label>
                        <p class="form-control-plaintext">{{ $customer->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($customer->notes)
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Additional Notes:</label>
                        <div class="form-control-plaintext bg-light p-3 rounded">
                            {{ $customer->notes }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="fw-bold">Attached Files:</label>
                        @if($customer->files && $customer->files->count() > 0)
                            <div class="list-group">
                                @foreach($customer->files as $file)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file me-2"></i>
                                            {{ $file->file_original_name }}
                                            <small class="text-muted d-block">
                                                Uploaded: {{ $file->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                        <div>
                                            <a href="{{ route('customer_files.show', $file->id) }}" 
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No files attached to this customer.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title"><i class="fas fa-chart-bar"></i> Customer Summary</h6>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="border-end">
                                        <h5 class="text-primary mb-1">{{ $customer->files->count() }}</h5>
                                        <small class="text-muted">Total Files</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border-end">
                                        <h5 class="text-success mb-1">{{ $customer->status == 'active' ? 'Yes' : 'No' }}</h5>
                                        <small class="text-muted">Active Status</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-info mb-1">{{ $customer->created_at->diffForHumans() }}</h5>
                                    <small class="text-muted">Created</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext {
    padding-left: 0;
    margin-bottom: 0;
}

.badge {
    font-size: 0.85em;
}

.list-group-item {
    border: 1px solid #dee2e6;
    margin-bottom: 5px;
    border-radius: 5px;
}

.border-end {
    border-right: 1px solid #dee2e6;
}

@media (max-width: 768px) {
    .border-end {
        border-right: none;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
}
</style>
@endsection