@extends('layouts.template')

@section('content')
    <div class="container">


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="card">
            <div class="card-header">
                <h4>Customer List</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Create New Customer</a>
            </div>
            <div class="card-body">


                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Status</th>
                            {{-- <th>Files</th> --}}
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->country }}</td>
                                <td>{{ ucfirst($customer->status) }}</td>

                                <td>{{ $customer->notes }}</td>
                                <td>
                                    @can('edit-customer')
                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                    @endcan
                                    @can('delete-customer')
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" type="submit"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
