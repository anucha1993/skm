@extends('layouts.template')

@section('content')
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show slide-up" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>รายการนายจ้าง</h4>
                    <small class="text-muted">จัดการข้อมูลนายจ้างทั้งหมด</small>
                </div>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>เพิ่มนายจ้างใหม่
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table" id="customersTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>รหัส</th>
                                <th><i class="fas fa-user me-2"></i>ชื่อนายจ้าง</th>
                                <th><i class="fas fa-flag me-2"></i>ประเทศ</th>
                                <th><i class="fas fa-toggle-on me-2"></i>สถานะ</th>
                                <th><i class="fas fa-sticky-note me-2"></i>หมายเหตุ</th>
                                <th><i class="fas fa-cogs me-2"></i>การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="table-status-badge" style="background: var(--gray-100); color: var(--gray-600); font-weight: 700;">
                                                #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-avatar">
                                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-gray-800">{{ $customer->name }}</div>
                                                <div class="text-sm text-gray-500">นายจ้าง</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-globe me-2 text-primary"></i>
                                            <span class="fw-medium">{{ $customer->country ?? 'ไม่ระบุ' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="table-status-badge {{ $customer->status == 'active' ? 'active' : 'inactive' }}">
                                            <i class="fas fa-{{ $customer->status == 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                            {{ $customer->status == 'active' ? 'ใช้งาน' : 'ไม่ใช้งาน' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-gray-600" style="max-width: 200px;">
                                            {{ $customer->notes ? Str::limit($customer->notes, 50) : 'ไม่มีหมายเหตุ' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            @can('edit-customer')
                                                <a href="{{ route('customers.edit', $customer->id) }}"
                                                   class="table-action-btn edit" 
                                                   title="แก้ไขข้อมูล"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            <a href="{{ route('customers.show', $customer->id) }}"
                                               class="table-action-btn" 
                                               style="background: rgba(6, 214, 160, 0.1); color: #059669;"
                                               title="ดูรายละเอียด"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('delete-customer')
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" 
                                                      style="display:inline-block;" 
                                                      onsubmit="return confirm('คุณต้องการลบข้อมูลนายจ้าง {{ $customer->name }} หรือไม่?\n\nการดำเนินการนี้ไม่สามารถย้อนกลับได้')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="table-action-btn delete" 
                                                            title="ลบข้อมูล"
                                                            data-bs-toggle="tooltip">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
/* Professional Table Enhancements */
#customersTable {
    font-size: 0.9rem;
}

.text-gray-800 {
    color: var(--gray-800) !important;
}

.text-gray-600 {
    color: var(--gray-600) !important;
}

.text-gray-500 {
    color: var(--gray-500) !important;
}

.text-sm {
    font-size: 0.8rem;
}

.fw-semibold {
    font-weight: 600;
}

.fw-medium {
    font-weight: 500;
}

/* Custom Professional Styling */
.card-body.p-0 {
    padding: 0 !important;
}

.table-container {
    margin-bottom: 0 !important;
}

/* Enhanced Hover Effects */
.table tbody tr:hover .table-avatar {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.table tbody tr:hover .table-status-badge {
    transform: translateY(-1px);
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .table-avatar {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    
    .table-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .table-action-btn {
        width: 32px;
        height: 32px;
    }
}

/* Professional Loading States */
.table tbody tr.loading {
    opacity: 0.6;
    pointer-events: none;
}

.table tbody tr.loading .table-avatar {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>

<script>
$(document).ready(function() {
    // Initialize Professional DataTable
    const table = $('#customersTable').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json',
            processing: '<div class="d-flex align-items-center"><i class="fas fa-spinner fa-spin me-2"></i>กำลังโหลดข้อมูล...</div>',
            emptyTable: '<div class="text-center py-4"><i class="fas fa-inbox fa-2x text-muted mb-3"></i><br>ไม่มีข้อมูลนายจ้าง</div>',
            zeroRecords: '<div class="text-center py-4"><i class="fas fa-search fa-2x text-muted mb-3"></i><br>ไม่พบข้อมูลที่ค้นหา</div>'
        },
        pageLength: 15,
        lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "ทั้งหมด"]],
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: [5] }, // Actions column
            { searchable: false, targets: [5] }  // Actions column
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function(settings) {
            // Initialize tooltips after table redraw
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Add loading animation
            $(this.api().table().node()).find('tbody tr').addClass('fade-in');
        }
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Enhanced search functionality
    $('.dataTables_filter input').attr('placeholder', 'ค้นหาข้อมูลนายจ้าง...');
    $('.dataTables_filter input').addClass('form-control-sm');
    
    // Professional pagination styling
    $('.dataTables_paginate .pagination').addClass('pagination-rounded');
    
    // Add refresh functionality
    if ($('.btn-refresh').length === 0) {
        $('.card-header .btn-primary').after(`
            <button type="button" class="btn btn-outline-primary ms-2 btn-refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        `);
    }
    
    $('.btn-refresh').on('click', function() {
        const btn = $(this);
        const icon = btn.find('i');
        
        icon.addClass('fa-spin');
        btn.prop('disabled', true);
        
        table.ajax.reload(function() {
            icon.removeClass('fa-spin');
            btn.prop('disabled', false);
        }, false);
    });
});
</script>
            </div>
        </div>
    </div>
@endsection
