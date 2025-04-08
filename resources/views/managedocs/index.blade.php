@extends('layouts.template')

@section('content')
    <div class="col-sm-12">

        <div class="card ">
            <div class="card-header">
                <h5>จัดการเอกสาร</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered nowrap dataTable" id="managedocs">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อระบบเอกสาร</th>
                            <th>เอกสารประเทศ</th>
                            <th>จำนวนเอกสาร</th>
                            <th>สถานะ</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($managedocs as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->managedoc_name }}</td>
                                <td>{{ $item->country->country_job_name }}</td>
                                <td> <span class="badge badge-pill badge-primary">{{ $item->managefile->count() }}
                                        รายการ</span></td>
                                <td>{!! $item->managedoc_status === 'Y'
                                    ? '<span class="badge badge-pill badge-success">เปิดใช้งาน</span>'
                                    : '<span class="badge badge-pill badge-danger">ปิดใช้งาน</span>' !!}</td>
                                <td>
                                    @can('edit-managedoc')
                                        <a href="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> แก้ไข</a>
                                    @endcan
                                    @can('delete-managedoc')
                                        <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> ลบ</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    
    @if ($managedocs->count() > 10)
        <script>
            $('#managedocs').DataTable();
        </script>
    @endif
@endsection
