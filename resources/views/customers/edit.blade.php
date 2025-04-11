@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
  <h4>Edit Customer</h4>

  
    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-2">
            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
        </div>
        
        <div class="form-group mb-2">
            <label>Country</label>
            <select name="country" class="form-control" required>
                <option value="">--Select Country--</option>
                <option value="USA" {{ $customer->country == 'USA' ? 'selected' : '' }}>USA</option>
                <option value="Thailand" {{ $customer->country == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                <!-- เพิ่มตัวเลือกตามความเหมาะสม -->
            </select>
        </div>
        
        <div class="form-group mb-2">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="disabled" {{ $customer->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
            </select>
        </div>
        
        <div class="form-group mb-2">
            <label>Existing Files</label>
            @if($customer->files->count())
                <ul class="list-unstyled">
                    @foreach($customer->files as $file)
                        <li>
                            <a href="{{ route('customer_files.show', $file->id) }}" target="_blank">
                                {{ $file->file_original_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No files attached.</p>
            @endif
        </div>
        
        <div class="form-group mb-2">
            <label>Attach New Files</label>
            <input type="file" name="files[]" class="form-control" multiple>
        </div>
        
        <div class="form-group mb-2">
            <label>Additional Notes</label>
            <textarea name="notes" class="form-control">{{ $customer->notes }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
</div>
</div>
@endsection
