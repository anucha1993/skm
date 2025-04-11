@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Create Customer</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-2">
                        <label>Customer Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Country</label>
                        <select name="country" class="form-control" required>
                            <option value="">--Select Country--</option>

                            @if(!empty($countryGlobalSet))
                                @php
                                    // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                    $values = $countryGlobalSet->values;
                                    if($countryGlobalSet->sort_order_preference == 'alphabetical') {
                                        $values = $values->sortBy('value');
                                    }
                                @endphp
                                @foreach($values as $item)
                                    <option value="{{ $item->id }}">{{ $item->value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="disabled">Disabled</option>
                            <option value="active">Active</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label>Attach Files</label>
                        <input type="file" name="files[]" class="form-control" multiple>
                    </div>

                    <div class="form-group mb-2">
                        <label>Additional Notes</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
