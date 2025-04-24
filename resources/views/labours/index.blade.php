@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">ข้อมูลคนงาน</h5></div>

            <div class="card-body">
                <table id="labours-table" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>รูปภาพ</th>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ</th>
                            <th>สกุล</th>
                            <th>โทรศัพท์</th>
                            
                            <th>จัดการ</th> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
        $('#labours-table').DataTable({
        processing: true,
        ajax: '{{ route("labours.data") }}',
        columns: [
            { data:'labour_id'},
            {
                data:'thumbnail', orderable:false, searchable:false,
                render: d => `<img src="${d || '{{ asset("images/user_icon.png") }}'}"
                     class="rounded-circle mx-auto d-block"
                     style="width:30px;height:30px;object-fit:cover;">`
            },
            { data:'labour_prefix'   },
            { data:'labour_firstname'},
            { data:'labour_lastname' },
            { data:'labour_phone_one'},
           
            {   // ***** ปุ่มดู-แก้ไข-ลบ *****
                data:'labour_id', orderable:false, searchable:false,
                render: function(id){
                    return `
                        <a href="{{ url('labours') }}/${id}" class="btn btn-sm btn-info me-1">ดู</a>
                        <a href="{{ url('labours') }}/${id}/edit" class="btn btn-sm btn-warning me-1">แก้ไข</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${id}">ลบ</button>
                    `;
                }
            },
        ],
        language:{ url:'//cdn.datatables.net/plug-ins/1.13.8/i18n/th.json' }
    });
    </script>
@endsection


