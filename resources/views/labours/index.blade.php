@extends('layouts.template')

@section('content')

@if(session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            alert(@json(session('success')));
        });
    </script>
@endif

<!-- DataTables CDN - โหลดที่หน้านี้เลย -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
/* Badge styles for data source */
.badge.bg-primary {
    background-color: #0d6efd !important;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
    border-radius: 0.375rem;
}

.badge i {
    font-size: 0.9em;
}

/* Table responsive adjustments */
#labours-table td {
    vertical-align: middle;
}

#labours-table .badge {
    white-space: nowrap;
}

/* Custom styles for source column */
#labours-table td:nth-child(4) {
    min-width: 140px;
    text-align: center;
}

/* Small text under badges */
#labours-table small.text-muted {
    font-size: 0.7em;
    line-height: 1.2;
    display: block;
    margin-top: 2px;
}

/* API badge specific styling */
.badge.bg-primary {
    box-shadow: 0 1px 3px rgba(13, 110, 253, 0.3);
}

.badge.bg-success {
    box-shadow: 0 1px 3px rgba(25, 135, 84, 0.3);
}

/* Hover effects */
#labours-table tbody tr:hover .badge {
    transform: translateY(-1px);
    transition: transform 0.15s ease-in-out;
}

/* Responsive design for mobile */
@media (max-width: 768px) {
    #labours-table td:nth-child(4) {
        min-width: 100px;
    }
    
    #labours-table small.text-muted {
        font-size: 0.65em;
    }
}

/* Filter buttons styling */
.filter-btn {
    font-size: 0.875em;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-btn.active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.btn-group .filter-btn {
    margin-right: 0;
}

.btn-group .filter-btn:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.btn-group .filter-btn:last-child {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.btn-group .filter-btn:not(:first-child):not(:last-child) {
    border-radius: 0;
}

/* Filter info text */
#filter-info {
    font-style: italic;
    font-weight: 500;
}

/* Manual search box styling */
#manual-search {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

#manual-search:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
}

#clear-search {
    border-left: none;
}

#search-info, #filter-info {
    display: block;
    margin-top: 2px;
}

/* Highlight search results */
.search-highlight {
    background-color: #fff3cd;
    font-weight: bold;
    padding: 1px 2px;
    border-radius: 2px;
}

/* Row visibility for filtering */
.table tbody tr.hidden {
    display: none !important;
}

/* Loading state */
.loading-state {
    opacity: 0.6;
    pointer-events: none;
}

@media (max-width: 768px) {
    #manual-search {
        font-size: 16px; /* ป้องกัน zoom บน iOS */
    }
    
    .btn-group .filter-btn {
        font-size: 0.8em;
        padding: 0.25rem 0.5rem;
    }
}
</style>

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
                    <!-- Search box and Filter buttons -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <!-- Manual search box (always visible) -->
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="manual-search" placeholder="ค้นหาข้อมูล (ชื่อ, รหัส, โทรศัพท์, ประเทศ, งาน)">
                                <button class="btn btn-outline-secondary" type="button" id="clear-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                <span id="search-info">พิมพ์เพื่อค้นหาข้อมูล</span>
                            </small>
                        </div>
                        <div class="col-md-6">
                            <!-- Filter buttons for data source -->
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="btn-group me-2" role="group" aria-label="Data Source Filter">
                                    <button type="button" class="btn btn-outline-secondary btn-sm filter-btn active" data-filter="all">
                                        <i class="fas fa-list me-1"></i>ทั้งหมด
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="api">
                                        <i class="fas fa-cloud-download-alt me-1"></i>จาก API
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="manual">
                                        <i class="fas fa-user-plus me-1"></i>สร้างเอง
                                    </button>
                                </div>
                                <small class="text-muted">
                                    <span id="filter-info">แสดงทั้งหมด</span>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <table id="labours-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัส</th>
                                <th>รูปภาพ</th>
                                <th>เลขบัตรประชาชน</th>
                                <th>ชื่อ-สกุล</th>
                                <th>แหล่งข้อมูล</th>
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
  
    <!-- โหลด DataTables JavaScript Libraries -->
  
    
    <script>
        // ตัวแปรสำหรับ retry counter
        let retryCount = 0;
        const maxRetries = 10; // จำกัดการ retry ไม่เกิน 10 ครั้ง
        
        // ฟังก์ชันตรวจสอบและเริ่มต้น DataTable
        function initializeDataTable() {
            retryCount++;
            
            // ตรวจสอบว่า jQuery โหลดแล้วหรือยัง
            if (typeof $ === 'undefined') {
                console.error('jQuery not loaded, retry:', retryCount);
                if (retryCount < maxRetries) {
                    setTimeout(initializeDataTable, 200);
                } else {
                    console.error('Max retries reached. jQuery failed to load.');
                    alert('ไม่สามารถโหลด jQuery ได้ กรุณารีเฟรชหน้าอีกครั้ง');
                }
                return;
            }
            
            // ตรวจสอบว่า DataTables โหลดแล้วหรือยัง
            if (typeof $.fn.DataTable === 'undefined') {
                console.error('DataTables library not loaded, retry:', retryCount);
                if (retryCount < maxRetries) {
                    setTimeout(initializeDataTable, 200);
                } else {
                    console.error('Max retries reached. DataTables failed to load.');
                    alert('ไม่สามารถโหลด DataTables ได้ กรุณารีเฟรชหน้าอีกครั้ง');
                }
                return;
            }

            console.log('Initializing DataTable... (attempt:', retryCount, ')');
            
            try {
                // Initialize DataTable
                const table = $('#labours-table').DataTable({
                    processing: true,
                    ajax: '{{ route('labours.data') }}',
                    columns: [{
                            data: 'labour_id'
                        },
                        { // idcard formatted
                            data: 'labour_idcard_number',
                            orderable: false,
                            searchable: false,
                            render: function(d) {
                                if (!d) return '-';
                                d = d.toString().padStart(13, '0');
                                if (d.length !== 13) return '-';
                                // Format: X-XXXX-XXXXX-XX-X
                                return `${d[0]}-${d.substr(1,4)}-${d.substr(5,5)}-${d.substr(10,2)}-${d[12]}`;
                            }
                        },
                        { // thumbnail
                            data: 'thumbnail',
                            orderable: false,
                            searchable: false,
                            render: function(d, type, row) {
                                const status = row.labourStatus?.value || '-';
                                return `
                                    <div class="text-center">
                                        <img src="${d}" class="rounded-circle mx-auto d-block" style="width:30px;height:30px;object-fit:cover;">
                                        <div style="font-size:0.85em;color:#888;">คนงาน</div>
                                        <div style="font-size:0.85em;color:#198754;">${status}</div>
                                    </div>
                                `;
                            }
                        },
                        { // >>> ชื่อ-สกุล
                            data: null, // รับทั้งแถว
                            render: function(data, type, row) {
                                // row.labour_prefix, row.labour_firstname, row.labour_lastname
                                return `${row.labour_prefix+'.'} ${row.labour_firstname} ${row.labour_lastname}`;
                            }
                        },
                        { // ***** NEW – แหล่งข้อมูล *****
                            data: null,
                            orderable: true,
                            searchable: true,
                            render: function(data, type, row) {
                                // ตรวจสอบว่าข้อมูลมาจาก API หรือไม่
                                const isFromAPI = row.is_from_api || row.api_candidate_id || row.source_type === 'api';
                                
                                if (isFromAPI) {
                                    let html = `
                                        <span class="badge bg-primary">
                                            <i class="fas fa-cloud-download-alt me-1"></i>
                                            API Import
                                        </span>
                                    `;
                                    
                                    // แสดง API Candidate ID ถ้ามี
                                    if (row.api_candidate_id) {
                                        html += `<br><small class="text-muted">API ID: ${row.api_candidate_id}</small>`;
                                    }
                                    
                                    // แสดงวันที่ import ถ้ามี
                                    if (row.api_imported_at) {
                                        const importDate = new Date(row.api_imported_at);
                                        const formattedDate = importDate.toLocaleDateString('th-TH', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        });
                                        html += `<br><small class="text-muted">นำเข้า: ${formattedDate}</small>`;
                                    }
                                    
                                    return html;
                                } else {
                                    let html = `
                                        <span class="badge bg-success">
                                            <i class="fas fa-user-plus me-1"></i>
                                            Manual Entry
                                        </span>
                                    `;
                                    
                                    // แสดงวันที่สร้าง
                                    if (row.created_at) {
                                        const createDate = new Date(row.created_at);
                                        const formattedDate = createDate.toLocaleDateString('th-TH', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        });
                                        html += `<br><small class="text-muted">สร้าง: ${formattedDate}</small>`;
                                    }
                                    
                                    return html;
                                }
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
                            render: d => d || '-' // HTML badge ที่สร้างมาแล้ว
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
                    responsive: true,
                    pageLength: 25,
                    order: [[0, 'desc']],
                    language: {
                        processing: "กำลังประมวลผล...",
                        search: "ค้นหา:",
                        lengthMenu: "แสดง _MENU_ รายการ",
                        info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                        infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
                        infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                        loadingRecords: "กำลังโหลด...",
                        zeroRecords: "ไม่พบข้อมูล",
                        emptyTable: "ไม่มีข้อมูลในตาราง",
                        paginate: {
                            first: "หน้าแรก",
                            previous: "ก่อนหน้า",
                            next: "ถัดไป",
                            last: "หน้าสุดท้าย"
                        }
                    }
                });

                // Filter functionality
                $('.filter-btn').on('click', function() {
                    const filter = $(this).data('filter');
                    
                    // Update active button
                    $('.filter-btn').removeClass('active');
                    $(this).addClass('active');
                    
                    // Apply filter
                    if (filter === 'all') {
                        table.column(3).search('').draw();
                        $('#filter-info').text('แสดงทั้งหมด');
                    } else if (filter === 'api') {
                        table.column(3).search('API Import').draw();
                        $('#filter-info').text('แสดงเฉพาะข้อมูลจาก API');
                    } else if (filter === 'manual') {
                        table.column(3).search('Manual Entry').draw();
                        $('#filter-info').text('แสดงเฉพาะข้อมูลที่สร้างเอง');
                    }
                });
                
                console.log('DataTable initialized successfully!');
            } catch (error) {
                console.error('Error initializing DataTable:', error);
                alert('เกิดข้อผิดพลาดในการโหลดตาราง: ' + error.message);
            }
        }

        // เริ่มต้นเมื่อ DOM และ script โหลดเสร็จ
        $(document).ready(function() {
            console.log('DOM ready, starting initialization...');
            
            // ลองใช้ DataTables ก่อน ถ้าไม่ได้ใช้ตารางธรรมดา
            if (typeof $.fn.DataTable !== 'undefined') {
                console.log('DataTables available, trying to initialize...');
                try {
                    const table = $('#labours-table').DataTable({
                        processing: true,
                        ajax: '{{ route('labours.data') }}',
                        columns: [
                            { data: 'labour_id' },
                            { 
                                data: 'thumbnail',
                                orderable: false,
                                searchable: false,
                                render: function(d, type, row) {
                                    
                                    const status = row.labourStatus.value || '-';
                                    return `
                                        <div class="text-center">
                                            <img src="${d}" class="rounded-circle mx-auto d-block" style="width:30px;height:30px;object-fit:cover;">
                                            <div style="font-size:0.85em;color:#888;">คนงาน</div>
                                            <div style="font-size:0.85em;color:#198754;">${status}</div>
                                        </div>
                                    `;
                                }
                            },
                            { 
                                data: null,
                                render: function(data, type, row) {
                                    return `${row.labour_prefix}. ${row.labour_firstname} ${row.labour_lastname}`;
                                }
                            },
                            { 
                                data: null,
                                render: function(data, type, row) {
                                    const isFromAPI = row.is_from_api || row.api_candidate_id;
                                    if (isFromAPI) {
                                        let html = `<span class="badge bg-primary"><i class="fas fa-cloud-download-alt me-1"></i>API Import</span>`;
                                        if (row.api_candidate_id) {
                                            html += `<br><small class="text-muted">API ID: ${row.api_candidate_id}</small>`;
                                        }
                                        return html;
                                    } else {
                                        return `<span class="badge bg-success"><i class="fas fa-user-plus me-1"></i>Manual Entry</span>`;
                                    }
                                }
                            },
                            { data: 'country.value', defaultContent: '-' },
                            { data: 'job_group.value', defaultContent: '-' },
                            { data: 'steps_badge', orderable: false, searchable: false, render: d => d || '-' },
                            { data: 'labour_phone_one' },
                            { 
                                data: 'labour_id',
                                orderable: false,
                                searchable: false,
                                render: id => `
                                    <a href="{{ url('labours') }}/${id}" class="btn btn-sm btn-info">ดู</a>
                                    <a href="{{ url('labours') }}/${id}/edit" class="btn btn-sm btn-warning">แก้ไข</a>
                                `
                            }
                        ],
                        pageLength: 25,
                        order: [[0, 'desc']],
                        language: {
                            processing: "กำลังประมวลผล...",
                            search: "ค้นหา:",
                            lengthMenu: "แสดง _MENU_ รายการ",
                            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                            paginate: {
                                previous: "ก่อนหน้า",
                                next: "ถัดไป"
                            }
                        }
                    });
                    
                    // Hide DataTables default search box และใช้ manual search แทน
                    $('.dataTables_filter').hide();
                    
                    // Manual search functionality for DataTables
                    $('#manual-search').on('keyup', function() {
                        const searchValue = this.value;
                        table.search(searchValue).draw();
                        
                        if (searchValue) {
                            $('#search-info').text(`ค้นหา: "${searchValue}"`);
                        } else {
                            $('#search-info').text('พิมพ์เพื่อค้นหาข้อมูล');
                        }
                    });
                    
                    // Clear search button
                    $('#clear-search').on('click', function() {
                        $('#manual-search').val('');
                        table.search('').draw();
                        $('#search-info').text('พิมพ์เพื่อค้นหาข้อมูล');
                    });
                    
                    // ตั้งค่าการกรอง
                    $('.filter-btn').on('click', function() {
                        const filter = $(this).data('filter');
                        $('.filter-btn').removeClass('active');
                        $(this).addClass('active');
                        
                        if (filter === 'all') {
                            table.column(3).search('').draw();
                            $('#filter-info').text('แสดงทั้งหมด');
                        } else if (filter === 'api') {
                            table.column(3).search('API Import').draw();
                            $('#filter-info').text('แสดงเฉพาะข้อมูลจาก API');
                        } else if (filter === 'manual') {
                            table.column(3).search('Manual Entry').draw();
                            $('#filter-info').text('แสดงเฉพาะข้อมูลที่สร้างเอง');
                        }
                    });
                    
                    console.log('DataTable initialized successfully!');
                } catch (error) {
                    console.error('DataTable error:', error);
                    createSimpleTable();
                }
            } else {
                console.log('DataTables not available, using simple table');
                createSimpleTable();
            }
        });
        
        // ฟังก์ชันสร้างตารางธรรมดา
        function createSimpleTable() {
            console.log('Creating simple table...');
            
            $.ajax({
                url: '{{ route('labours.data') }}',
                type: 'GET',
                success: function(response) {
                    const data = response.data;
                    const tbody = $('#labours-table tbody');
                    tbody.empty();
                    
                    // เก็บข้อมูลต้นฉบับสำหรับการค้นหา
                    window.originalTableData = data;
                    
                    if (data && data.length > 0) {
                        data.forEach(function(row) {
                            // DEBUG: log id and idcard
                            console.log('row.labour_id:', row.labour_id, 'row.labour_idcard_number:', row.labour_idcard_number, typeof row.labour_idcard_number);
                            const isFromAPI = row.is_from_api || row.api_candidate_id || row.source_type === 'api';
                            let sourceHtml = '';
                            if (isFromAPI) {
                                sourceHtml = `<span class="badge bg-primary"><i class="fas fa-cloud-download-alt me-1"></i>API Import</span>`;
                                if (row.api_candidate_id) {
                                    sourceHtml += `<br><small class="text-muted">API ID: ${row.api_candidate_id}</small>`;
                                }
                            } else {
                                sourceHtml = `<span class="badge bg-success"><i class="fas fa-user-plus me-1"></i>Manual Entry</span>`;
                            }
                            const fullName = `${row.labour_prefix}. ${row.labour_firstname} ${row.labour_lastname}`;
                            const country = row.country?.value || '-';
                            const jobGroup = row.job_group?.value || '-';
                            const phone = row.labour_phone_one || '-';
                            const status = row.labourStatus?.value || '-';
                            // Format 13-digit ID card
                            let idcardDisplay = '-';
                            let d = row.labour_idcard_number;
                            if (d !== undefined && d !== null && d !== '') {
                                d = d.toString();
                                // Remove all non-digit characters just in case
                                d = d.replace(/\D/g, '');
                                if (d.length === 13) {
                                    idcardDisplay = `${d[0]}-${d.substr(1,4)}-${d.substr(5,5)}-${d.substr(10,2)}-${d[12]}`;
                                } else {
                                    idcardDisplay = d; // Show raw if not 13 digits for debug
                                }
                            }
                            const tableRow = `
                                <tr data-source="${isFromAPI ? 'api' : 'manual'}" 
                                    data-search="${row.labour_id} ${fullName} ${phone} ${country} ${jobGroup} ${row.api_candidate_id || ''}">
                                    <td>${row.labour_id}</td>
                                     
                                    <td class="text-center">
                                        <img src="${row.thumbnail}" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;">
                                    ${status ? `<div style="font-size:0.85em;color:#888;">${status}</div>` : ''}
                                    </td>
                                      <td>${idcardDisplay}</td>
                                    <td>${fullName}</td>
                                    <td class="text-center">${sourceHtml}</td>
                                    <td>${country}</td>
                                    <td>${jobGroup}</td>
                                    <td>${row.steps_badge || '-'}</td>
                                    <td>${phone}</td>
                                    <td class="text-center">
                                        <a href="{{ url('labours') }}/${row.labour_id}" class="btn btn-sm btn-info me-1">ดู</a>
                                        <a href="{{ url('labours') }}/${row.labour_id}/edit" class="btn btn-sm btn-warning me-1">แก้ไข</a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete-labour" data-id="${row.labour_id}"><i class="bi bi-trash"></i> ลบ</button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(tableRow);
                        });
                        
                        console.log(`Loaded ${data.length} records successfully`);
                    } else {
                        tbody.append('<tr><td colspan="9" class="text-center">ไม่มีข้อมูล</td></tr>');
                    }
                    
                    // Manual search functionality for simple table
                    $('#manual-search').off('keyup').on('keyup', function() {
                        const searchValue = this.value.toLowerCase();
                        const rows = $('#labours-table tbody tr[data-search]');
                        
                        if (searchValue) {
                            let visibleCount = 0;
                            rows.each(function() {
                                const searchText = $(this).attr('data-search').toLowerCase();
                                if (searchText.includes(searchValue)) {
                                    $(this).show();
                                    visibleCount++;
                                } else {
                                    $(this).hide();
                                }
                            });
                            $('#search-info').text(`ค้นหา: "${this.value}" (พบ ${visibleCount} รายการ)`);
                        } else {
                            rows.show();
                            $('#search-info').text('พิมพ์เพื่อค้นหาข้อมูล');
                        }
                        
                        // อัพเดท filter info ตามผลการค้นหา
                        updateFilterInfo();
                    });
                    
                    // Clear search button
                    $('#clear-search').off('click').on('click', function() {
                        $('#manual-search').val('');
                        $('#labours-table tbody tr[data-search]').show();
                        $('#search-info').text('พิมพ์เพื่อค้นหาข้อมูล');
                        updateFilterInfo();
                    });
                    
                    // ตั้งค่าการกรอง
                    $('.filter-btn').off('click').on('click', function() {
                        const filter = $(this).data('filter');
                        $('.filter-btn').removeClass('active');
                        $(this).addClass('active');
                        
                        const rows = $('#labours-table tbody tr[data-search]');
                        const searchValue = $('#manual-search').val().toLowerCase();
                        
                        if (filter === 'all') {
                            rows.each(function() {
                                if (!searchValue || $(this).attr('data-search').toLowerCase().includes(searchValue)) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            });
                        } else if (filter === 'api') {
                            rows.each(function() {
                                const isAPI = $(this).attr('data-source') === 'api';
                                const matchesSearch = !searchValue || $(this).attr('data-search').toLowerCase().includes(searchValue);
                                if (isAPI && matchesSearch) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            });
                        } else if (filter === 'manual') {
                            rows.each(function() {
                                const isManual = $(this).attr('data-source') === 'manual';
                                const matchesSearch = !searchValue || $(this).attr('data-search').toLowerCase().includes(searchValue);
                                if (isManual && matchesSearch) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            });
                        }
                        
                        updateFilterInfo();
                    });
                    
                    // ฟังก์ชันอัพเดทข้อมูลการกรอง
                    function updateFilterInfo() {
                        const activeFilter = $('.filter-btn.active').data('filter');
                        const visibleRows = $('#labours-table tbody tr[data-search]:visible').length;
                        const totalRows = $('#labours-table tbody tr[data-search]').length;
                        
                        if (activeFilter === 'all') {
                            $('#filter-info').text(`แสดงทั้งหมด (${visibleRows}/${totalRows})`);
                        } else if (activeFilter === 'api') {
                            const totalAPI = $('#labours-table tbody tr[data-source="api"]').length;
                            $('#filter-info').text(`แสดงเฉพาะข้อมูลจาก API (${visibleRows}/${totalAPI})`);
                        } else if (activeFilter === 'manual') {
                            const totalManual = $('#labours-table tbody tr[data-source="manual"]').length;
                            $('#filter-info').text(`แสดงเฉพาะข้อมูลที่สร้างเอง (${visibleRows}/${totalManual})`);
                        }
                    }
                    
                    // เรียกใช้ครั้งแรก
                    updateFilterInfo();
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', error);
                    $('#labours-table tbody').html('<tr><td colspan="9" class="text-center text-danger">ไม่สามารถโหลดข้อมูลได้: ' + error + '</td></tr>');
                }
            });
        }

        // Fallback: ถ้า DOM ready ไม่ทำงาน
        window.addEventListener('load', function() {
            console.log('Window loaded, checking if table needs initialization...');
            if ($('#labours-table tbody tr').length === 0) {
                console.log('Table empty, trying fallback initialization...');
                setTimeout(createSimpleTable, 1000);
            }
        });
        
        // เพิ่ม event delegation สำหรับปุ่มลบ
        $('#labours-table').off('click', '.btn-delete-labour').on('click', '.btn-delete-labour', function() {
            const labourId = $(this).data('id');
            if (confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')) {
                $.ajax({
                    url: `{{ url('labours') }}/${labourId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        // ลบแถวออกจากตารางทันที
                        $(`#labours-table tbody tr`).filter(function() {
                            return $(this).find('td:first').text() == labourId;
                        }).remove();
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                    },
                    error: function(xhr) {
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    }
                });
            }
        });
    </script>
@endsection
