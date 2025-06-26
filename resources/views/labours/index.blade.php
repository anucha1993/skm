@extends('layouts.template')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h3 class="text-success">{{ $totalLabours }}</h3>
                        <h6 class="text-muted m-b-0">คนงานทั้งหมด</h6>
                        
                    </div>
                    <div class="col-6">
                        <div id="seo-chart1" class="d-flex align-items-end"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @foreach ($statusCounts as $label => $count)
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h3>{{ $count }}</h3>
                        <h6 class="text-muted m-b-0">{{ $label }}</h6>
                    </div>
                    <div class="col-6">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    </div>

  

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">ข้อมูลคนงาน</h5>
                    <a href="{{route('labours.create')}}">เพิ่มข้อมูล</a>
                </div>

                <div class="card-body">
                    <table id="labours-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัส</th>
                                <th>รูปภาพ</th>
                                <th>ชื่อ-สกุล</th>
                                <th>ประเทศ</th>
                                <th>ประเภทงาน</th>
                                <th>Steps</th>
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
            ajax: '{{ route('labours.data') }}',
            columns: [{
                    data: 'labour_id'
                },
                { // thumbnail
                    data: 'thumbnail',
                    orderable: false,
                    searchable: false,
                    render: d => `
                <img src="${d}" class="rounded-circle mx-auto d-block"
                     style="width:30px;height:30px;object-fit:cover;">
            `
                },
                { // >>> ชื่อ-สกุล
                    data: null, // รับทั้งแถว
                    render: function(data, type, row) {
                        // row.labour_prefix, row.labour_firstname, row.labour_lastname
                        return `${row.labour_prefix+'.'} ${row.labour_firstname} ${row.labour_lastname}`;
                    }
                },

                {
                    data: 'country.value',
                    defaultContent: '-'
                },
                {
                    data: 'job_group.value',
                    title: 'งาน',
                    defaultContent: '-'
                },


                { // ***** NEW – Steps *****
                    data: 'steps_badge',
                    orderable: false,
                    searchable: false,
                    render: d => d // HTML badge ที่สร้างมาแล้ว
                },

                {
                    data: 'labour_phone_one'
                },

                { // ***** ปุ่มจัดการ *****
                    data: 'labour_id',
                    orderable: false,
                    searchable: false,
                    render: id => `
                <form  action="{{ url('labours/${id}') }}" method="post">
                      @csrf
                      @method('DELETE')
                <a href="{{ url('labours') }}/${id}" class="btn btn-sm btn-info me-1">ดู</a>
                @can('edit-labour')
                <a href="{{ url('labours') }}/${id}/edit" class="btn btn-sm btn-warning me-1">แก้ไข</a>
                 @endcan
                   @can('delete-labour')
               <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Data?');"><i class="bi bi-trash"></i> ลบ</button>
                 @endcan
            `
                },
            ],
            // language: {
            //     url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/th.json'
            // }
        });
    </script>
@endsection
